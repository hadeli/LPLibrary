<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BookController extends AbstractController
{
    function list() {
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->json($books);
    }

    function detail(int $id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        return $this->json($book);
    }

    function delete(int $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        $entityManager->remove($book);
        return $this->json($book);
    }

    function put(int $id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        return $this->json($book);
    }

    function combien(int $id){


    }

}