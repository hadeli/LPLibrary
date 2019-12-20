<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Book;
use Symfony\Component\HttpFoundation\JsonResponse;
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

//    public function addBook(){
//        $book = new Book (1, 'Bambou', '939710589-2', 5);
//        return $this->json($book);
//    }
//
//    public function putBook($book){
//        return new JsonResponse($book);
//    }
}