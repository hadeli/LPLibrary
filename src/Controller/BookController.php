<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController {

    public function displayAll(){
        $books = $this->getDoctrine()
                    ->getRepository(Book::class)
                    ->findAll();
        return $this->json($books,200);
    }

    public function display($id){
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);
        if (!$book){
            throw $this->createNotFoundException(
              "No books found with this id : $id"
            );
        }
        return $this->json($book,200);
    }

    public function delete($id){
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);
        if (!$book){
            throw $this->createNotFoundException(
                "No books found with this id : $id"
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->json([], 204);
    }
    public function add(Request $request){
        $manager = $this->getDoctrine()->getManager();
        $name = $request->get("name");
        $isbn = $request->get("isbn");
        $categoryId = $request->get("categoryId");

        $book = new Book($name,$isbn,$categoryId);

        $manager->persist($book);
        $manager->flush();

        return $this->json($book,201);
    }

    public function update(Request $request, int $id) {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);
        if (!$book){
            throw $this->createNotFoundException(
                "No books found with this id : $id"
            );
        }
        $manager = $this->getDoctrine()->getManager();

        $name = $request->get("name");
        $isbn = $request->get("isbn");
        $categoryId = $request->get("categoryId");

        if ($name) {
            $book->setName($name);
        }
        if ($isbn) {
            $book->setName($isbn);
        }
        if ($categoryId) {
            $book->setName($categoryId);
        }

        $manager->flush();
        return $this->json($book,200);

    }

}