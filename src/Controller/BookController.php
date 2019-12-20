<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Category;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Lending;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    public function list(){
        return $this->json($this->getDoctrine()->getRepository(Book::class)->findAll(),Response::HTTP_ACCEPTED);
    }

    public function getBook($id){
        $book = $this->getDoctrine()->getManager()->getRepository(Book::class)->find($id);
        if($book === NULL){
            return $this->json(array('message'=>'This book does not exist'),Response::HTTP_NOT_FOUND);
        }
        return $this->json($book);
    }

    public function create(Request $request){
        $book = new Book();
        $book->setName($request->query->get('name'));

        if(!$request->query->get('category_id')){
            return $this->json(array('message'=>'Please provide a category_id'),Response::HTTP_BAD_REQUEST);
        }

        /** @var Category $category */
        $category = $this->getDoctrine()->getManager()->getRepository(Category::class)->find($request->query->get('category_id'));
        //On check si la catégorie existe bien
        if($category === NULL){
            return $this->json(array('message'=>'This category does not exist'),Response::HTTP_NOT_FOUND);
        }
        $book->setCategory($category);

        $book->setIsbn($request->query->get('isbn'));
        $this->getDoctrine()->getManager()->persist($book);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($book,Response::HTTP_CREATED);
    }

    public function edit($id, Request $request){
        $book = $this->getDoctrine()->getManager()->getRepository(Book::class)->find($id);
        if($book === NULL){
            return $this->json(array('message'=>'This book does not exist'),Response::HTTP_NOT_FOUND);
        }
        $book->setName($request->query->get('name'));

        if($request->query->get('category_id')){
            /** @var Category $category */
            $category = $this->getDoctrine()->getManager()->getRepository(Category::class)->find($request->query->get('category_id'));
            //On check si la catégorie existe bien
            if($category === NULL){
                return $this->json(array('message'=>'This category does not exist'),Response::HTTP_NOT_FOUND);
            }
            $book->setCategory($category);
        }

        $book->setIsbn($request->query->get('isbn'));

        $this->getDoctrine()->getManager()->persist($book);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($book,Response::HTTP_CREATED);
    }

    public function delete($id){
        $bookToRemove = $this->getDoctrine()->getManager()->getRepository(Book::class)->find($id);
        if($bookToRemove === NULL){
            return $this->json(array('message'=>'This book does not exist'),Response::HTTP_NOT_FOUND);
        }
        try{
            $this->getDoctrine()->getManager()->remove($bookToRemove);
            $this->getDoctrine()->getManager()->flush();
        }
        catch (ForeignKeyConstraintViolationException $e){
            return $this->json(array('message'=>'You can not delete this book : it is in use in the database'),Response::HTTP_NOT_FOUND);
        }

        return $this->json(array('message'=>'Book successfully deleted'),Response::HTTP_ACCEPTED);
    }

    public function getBookReaders($id){
        /** @var Book $book */
        $book = $this->getDoctrine()->getManager()->getRepository(Book::class)->find($id);
        if($book === NULL){
            return $this->json(array('message'=>'This book does not exist'),Response::HTTP_NOT_FOUND);
        }
        /** @var Copy[] $allCopies */
        $allCopies = $this->getDoctrine()->getManager()->getRepository(Copy::class)->findBy(array('book_id' => $book->getId()));
        $readers = array();
        foreach ($allCopies as $copy){
            /** @var Lending $lending */
            $lending = $this->getDoctrine()->getManager()->getRepository(Lending::class)->findOneBy(array('copy_id' => $copy->getId()));
            if($lending){
                array_push($readers,$lending->getReader());
            }
        }
        return $this->json($readers,Response::HTTP_ACCEPTED);
    }
}