<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Category;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Lending;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    public function get_book_list(){
        $book_list = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->json($book_list);
    }
    public function get_book($id){
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if(is_null($book))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);
        return $this->json($book);
    }
    public function put_book(Request $request){
        $book = new Book();

        $isbn = $request->query->get('isbn');
        $name = $request->query->get('name');
        $category_id = $request->query->get('category');

        $book->setIsbn($isbn);
        $book->setName($name);

        if(isset($category_id)){
            /** @var Category $category */
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category_id);
            if(is_null($book))
                return $this->json(array("message" => "category not found"), Response::HTTP_NOT_FOUND);
            $book->setCategory($category);
        }else
            return $this->json("Catégorie manquante");

        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

        return $this->json($book, Response::HTTP_CREATED);

    }
    public function patch_book($id, Request $request){
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if(is_null($book))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);

        $isbn = $request->query->get('isbn');
        $name = $request->query->get('name');
        $category_id = $request->query->get('category');

        if(isset($isbn) && !empty($isbn))
            $book->setIsbn($isbn);
        if(isset($name) && !empty($name))
            $book->setName($name);

        if(isset($category_id)){
            /** @var Category $category */
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category_id);
            if(is_null($book))
                return $this->json(array("message" => "category not found"), Response::HTTP_NOT_FOUND);
            $book->setCategory($category);
        }else
            return $this->json("Catégorie manquante");

        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

        return $this->json($book);


    }
    public function delete_book($id){
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if(is_null($book))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);

        try {

            $em = $this->getDoctrine()->getManager();
            $em->remove($book);
            $em->flush();
            return $this->json(null, Response::HTTP_NO_CONTENT);

        }catch (ForeignKeyConstraintViolationException $e){
            return $this->json("Erreur lors de la suppresion", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function readers($id){
        $copy_list = $this->getDoctrine()->getRepository(Copy::class)->findBy(array("book" => $id));
        $readers = array();
        /** @var Copy $copy */
        foreach ($copy_list as $copy){
            /** @var Lending $lending */
            $lending = $this->getDoctrine()->getRepository(Lending::class)->findOneBy(array("copy" => $copy->getId()));
            if(!is_null($lending))
                array_push($readers, $lending->getReader());
        }
        return $this->json($readers);

    }
}