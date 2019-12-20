<?php


namespace Alexandrie\Controller\Library;


use Alexandrie\Entity\Library\Book;
use Alexandrie\Entity\Library\Library;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    public function listBooks()
    {
        $books = $this-> getDoctrine()
            -> getRepository(Book::class)
            -> findAll();

        try {
            return new Response($this-> json($books));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function showBook($id) {
        $book = $this-> getDoctrine()
            -> getRepository(Book::class)
            -> find($id);

        try {
            return new Response($this-> json($book));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function createBook(Request $request)
    {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $book = new Book();

        if (null !== $request->get('name')) {
            if ($request->get('name'))
                $book->setName($request->get('name'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('category')) {
            if ($request->get('category'))
                $book->setCategory($request->get('category'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('isbn')) {
            if ($request->get('isbn'))
                $book->setIsbn($request->get('isbn'));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($book);
        try {
            $entityManager-> flush();
            return new Response($this-> json($book));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function updateBook(Request $request, $id)
    {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $book = $this-> getDoctrine()
            -> getRepository(Book::class)
            -> find($id);

        if (null !== $request->get('name')) {
            if ($request->get('name'))
                $book->setName($request->get('name'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('category')) {
            if ($request->get('category'))
                $book->setCategory($request->get('category'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('isbn')) {
            if ($request->get('isbn'))
                $book->setIsbn($request->get('isbn'));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($book);
        try {
            $entityManager-> flush();
            return new Response($this-> json($book));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function deleteBook($id)
    {
        $entityManager = $this-> getDoctrine()
            ->getManager();

        $book = $this-> getDoctrine()
            -> getRepository(Book::class)
            -> find($id);

        $entityManager-> remove($book);
        try {
            $entityManager-> flush();
            return new Response($this-> json($book));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function booksLended($id)
    {
        $library = $this-> getDoctrine()
            -> getRepository(Library::class)
            -> find($id);

        $library_array = json_decode($library);
        $numberOfBooks = count($library_array->library);


        try {
            return new Response($this-> json($numberOfBooks));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }
}