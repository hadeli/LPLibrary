<?php


namespace Alexandrie\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Alexandrie\Entity\Book;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{

    public function listBookAction()
    {
        $Book_list = $this->getDoctrine()->getRepository(Book::class)->findAll();

        return $this->json([$Book_list], 200);
    }

    public function listBookByIdAction($id)
    {
        $Book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        return $this->json($Book, 200);
    }

    public function deleteBookByIdAction($id)
    {
        $Book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Book);
        $entityManager->flush();

        return $this->json($Book, 204);
    }

    public function addBook(Request $request)
    {

        $Book = new Book();

        $Book->setIsbn($request->get("isbn"));
        $Book->setName($request->get("name"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Book); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($Book, 201);
    }

    public function updateBook(Request $request, $id)
    {
        $Book = $this->getDoctrine()->getRepository(Book::class)->find($id);


        $Book->setIsbn($request->get("isbn"));
        $Book->setName($request->get("name"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Book);
        $entityManager->flush();

        return $this->json($Book, 200);
    }
}