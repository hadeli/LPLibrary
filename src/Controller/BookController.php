<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController {
    public function bookList() {
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->json($books);
    }

    public function getBook(int $id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if (is_null($book)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        return $this->json($book);
    }

    public function deleteBook(int $id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if (is_null($book)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $this->getDoctrine()->getManager()->remove($book);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    public function addBook(Request $request) {
        $book = new Book();
        $name = $request->query->get('name');
        $isbn = $request->query->get('isbn');
        $category_id = $request->query->get('category');
        $category = $this->getDoctrine()->getRepository(Category::class)->find($category_id);
        $book->setName($name);
        $book->setIsbn($isbn);
        $book->setCategory($category);
        $this->getDoctrine()->getManager()->persist($book);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($book, Response::HTTP_CREATED);
    }
    public function editBook(int $id, Request $request) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if (is_null($book)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $name = $request->query->get('name');
        $isbn = $request->query->get('isbn');
        $category_id = $request->query->get('category');
        if (isset($name)) $book->setName();
        if (isset($isbn)) $book->setIsbn();
        if (isset($category_id)) {
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category_id);
            $book->setCategory($category);
        }
        $this->getDoctrine()->getManager()->persist($book);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($book);
    }
}