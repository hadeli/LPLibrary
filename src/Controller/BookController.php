<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookController extends AbstractController
{

    public function create(){
        $entityManager = $this->getDoctrine()->getManager();

        $book = new Book();
        $book->setName($this->randomName(10));
        $book->setIsbn(substr($book->getName(), 0, 5));

        $entityManager->persist($book);
        $entityManager->flush();
        return new JsonResponse(["status" => "Book entré en base de données"]);

    }

    private function randomName($times){
        $carac = '0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN';
        $final = '';
        for($i=0; $i < 10; $i += 1){
            $letter = rand(0, strlen($carac)-1);
            $final .= $carac[$letter];
        }
        return $final;
    }

    public function list(){
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();

        return $this->json($books);
    }

    public function retrieve($id){
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        return $this->json($book);
    }

    public function update($id){
        $entityManager = $this->getDoctrine()->getManager();

        $toUpdate = $this->getDoctrine()->getRepository(Book::class)->find($id);

        if (!$toUpdate){
            throw $this->createNotFoundException('Not existing for id : '.$id);
        }

        $toUpdate->setName($this->randomName(10));
        $toUpdate->setIsbn($this->randomName(5));

        $entityManager->flush();

        return $this->json(['status' => 'Book mis à jour']);
    }

    public function delete($id){
        $entityManager = $this->getDoctrine()->getManager();

        $toDelete = $this->getDoctrine()->getRepository(Book::class)->find($id);

        $entityManager->remove($toDelete);
        $entityManager->flush();

        return $this->json(['status' => 'Book supprimé']);
    }
}