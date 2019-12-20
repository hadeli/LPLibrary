<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use http\Env\Request;
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

   public function updateBook($id){
        $entityManager = $this->getDoctrine()->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);
        if (!$book){
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }
        $book->setName('Book name');
        $entityManager->flush();

        return $this->redirectToRoute('bookslist',[
            'id' => $book->getId()
        ]);
   }
}