<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class BookController extends AbstractController
{

    public function listBook(){
        $list = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->json($list, 200);
    }

    public function listBookById($id){
        $result = $this->getDoctrine()->getRepository(Book::class)->find($id);
        return $this->json($result, 200);
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

    public function deleteBook($id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($book);
        $entityManager->flush();
        return $this->json([], 204);
    }

    public function createBook(Request $request) {
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