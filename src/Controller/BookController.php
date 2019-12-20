<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController{

    public function bookList(){
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->json($books);
    }

    public function getBook(Book $id){
        $books = $this->getDoctrine()->getRepository(Book::class)->find($id);
        return $this->json($books);
    }

    public function deleteBook(Book $id){
        $books = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $this->getDoctrine()->getManager()->remove($books);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(null);
    }

}