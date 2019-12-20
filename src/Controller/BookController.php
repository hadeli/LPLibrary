<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController implements ObjectController {

    public function displayAll() {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->findAll();
        return $this->json($book,200);
    }

    public function display(int $id) {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);
        if (!$book) {
            return $this->createNotFoundException();
        }
        return $this->json($book,200);
    }

    public function getReaders($id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if (!$book) {
            return $this->createNotFoundException();
        }
    }

    public function delete(int $id) {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($book);
        $entityManager->flush();
        return $this->json([], 204);
    }

    public function update(Request $request, int $id) {
        $manager = $this->getDoctrine()->getManager();
        $book = $manager->getRepository(Book::class)->find($id);
        $name = $request->get("name");
        $isbn = $request->get("isbn");
        $categoryId = $request->get("categoryId");

        if ($name != null) {
            $book->setName($name);
        }
        if ($isbn != null) {
            $book->setIsbn($isbn);
        }
        if ($categoryId != null) {
            $book->setCategoryId($categoryId);
        }
        $manager->flush();
        return $this->json($book,200);
    }

    public function add(Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $name = $request->get("name");
        $isbn = $request->get("isbn");
        $categoryId = $request->get("categoryId");
        $book = new Book();
        $book->setName($name);
        $book->setIsbn($isbn);
        $book->setCategoryId($categoryId);
        $manager->persist($book);
        $manager->flush();
        return $this->json($book,201);
    }
}