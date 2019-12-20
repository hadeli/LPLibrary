<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController{

    public function bookList(){
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->json($books);
    }

}