<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Book;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Lending;
use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class BookController
 * @package Alexandrie\Controller
 */
class BookController extends AbstractController
{
    /**
     * @return string
     */
    public function listBookAction()
    {
        $book_list = $this->getDoctrine()->getRepository(Book::class)->findAll();

        return $this->json($book_list, 200);
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listBookByIdAction(int $id)
    {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        return $this->json($book, 200);
    }

    /**
     * @param int $id
     * @return string
     */
    public function deleteBookByIdAction(int $id): string
    {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->json($book, 204);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function createBookAction(Request $request): string
    {
        $name = $request->get("name");
        $isbn = $request->get("isbn");

        $book = new Book();

        $book->setName($name);
        $book->setIsbn($isbn);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($book); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($book, 201);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return string
     */
    public function updateBookByIdAction(Request $request, int $id): string
    {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        $name = $request->get("name");
        $isbn = $request->get("isbn");

        $book->setName($name);
        $book->setIsbn($isbn);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($book);
        $entityManager->flush();

        return $this->json($book, 200);
    }

    public function getReadersByBookId($id)
    {
        // Contains a single book.
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        // Finds the book's relations.
        //$copy = $this->getDoctrine()->getRepository(Copy::class)->find($book);
        $copy = $this->getDoctrine()->getRepository(Copy::class)->findBy(["book_id" => $book]);
        //$lending = $this->getDoctrine()->getRepository(Lending::class)->findBy(["copy_id" => $copy->getId()]);
        $lending = $this->getDoctrine()->getRepository(Lending::class)->findBy(["copy_id" => $copy->getBookId()]);
        //$readers = $this->getDoctrine()->getRepository(Reader::class)->findBy(["id" => $lending->getReaderId()]);

        //$readers = $this->getDoctrine()->getRepository(Reader::class)->findAll();

        return $this->json($copy, 200);
    }
}
