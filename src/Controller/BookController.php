<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Book;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Lending;
use Alexandrie\Entity\Reader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    public function listBook(){
        $book_list = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->json($book_list);
    }

    public function listBookById($id){
        $book_id = $this->getDoctrine()->getRepository(Book::class)->find($id);
        return $this->json($book_id);
    }

    public function deleteBookById($id){
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->json($book, 204);
    }

    public function addBookById(Request $request){
        $book = new Book();

        $book->setIsbn($request->get("isbn"));
        $book->setName($request->get("name"));
        $book->setCategoryId($request->get("category_id"));


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($book);
        $entityManager->flush();
        return $this->json($book, 201);
    }

    public function updateBook(Request $request, $id){
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        $book->setIsbn($request->get("isbn"));
        $book->setName($request->get("name"));
        $book->setCategoryId($request->get("category_id"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($book);
        $entityManager->flush();

        return $this->json($book, 200);
    }

    public function getBookReaders($id){
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($book);
        $lending = $this->getDoctrine()->getRepository(Lending::class)->findBy(array('copy_id' => $copy->getId()));
        $reader = $this->getDoctrine()->getRepository(Reader::class)->findBy(array('id' => $lending->getFirstName()));

        return $this->json($reader, 200);
    }

}