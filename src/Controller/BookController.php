<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    public function bookList()
    {
        return $this->json($this->getDoctrine()->getRepository(Book::class)->findAll());
    }

    public function getBook($id)
    {
        return $this->json($this->getDoctrine()->getRepository(Book::class)->find($id));
    }

    public function createBook(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        if ($request->get('name') != "" && $request->get('isbn') != "" && $request->get('category_id') != "") {
            $name = $request->get('name');
            $isbn = $request->get('isbn');
            $category_id = $request->get('category_id');
        }
        else
            return new Response("veuillez remplir tous les champs");

        $product = new Book(NULL, $name, $isbn, $category_id);
        $entityManager->persist($product);
        $entityManager->flush();
        try{
            return new Response($this->json($product));
        }catch (Exception $exception){
            return new Response($exception->getMessage());
        }
    }

    public function updateBook(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if (null !== $request->get('id')){
            if ($request->get('name') != "")
                $product->setName($request->get('name'));
            if ($request->get('isbn') != "")
                $product->setIsbn($request->get('isbn'));
            if ($request->get('category_id') != "")
                $product->setCategoryId($request->get('category_id'));
        }
        else
            return new Response("veuillez remplir correctement les champs");
        $entityManager->persist($product);
        $entityManager->flush();
        try{
            return new Response($this->json($product));
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }

    public function deleteBook($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return new JsonResponse('Book removed');
    }

    public function bookLending($id)
    {
        //$book = $this->getDoctrine()->getRepository(Book::class)->findBookReaders($id);

    }
}