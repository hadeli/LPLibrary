<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    public function listBook()
    {
        $reader = $this->getDoctrine()
            ->getRepository(Book::class)
            ->findAll();
        return $this->json($reader);
    }

    public function createBook(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->get('name') != "" && $request->get('isbn') != "" && $request->get('category_id') != "")
        {
            $name = $request->get('name');
            $isbn = $request->get('isbn');
            $categoryId = $request->get('category_id');


        }else
            return new Response("Il est nécessaire de remplir tous les champs pour la création");

        $book = new Book(NULL, $name, $isbn, $categoryId);

        $entityManager->persist($book);
        $entityManager->flush();

        return new Response($this->json($book));
    }

    public function showBook($id)
    {
        $reader = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);
        return $this->json($reader);
    }

    public function updateBook(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this->getDoctrine()->getRepository(Book::class)->find($id);

        if (null !== $request->get('id')) {
            if ($request->get('name') != "") {$reader->setName($request->get('name'));}
            if ($request->get('isbn') != "") {$reader->setIsbn($request->get('isbn'));}
            if ($request->get('category_id') != "") {$reader->setCategoryId($request->get('category_id'));}
        }

        $entityManager->persist($reader);
        $entityManager->flush();

        try {
            return new Response($this->json($reader));
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function deleteBook($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this-> getDoctrine()->getRepository(Book::class)->find($id);

        $entityManager->remove($reader);
        $entityManager->flush();
        return $this->json($reader);
    }
}