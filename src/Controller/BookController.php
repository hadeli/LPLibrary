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

    public function updateBook($id)
    {
        $result = $this->getDoctrine()->getManager();
        $book = $result->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $book->setName('New book name!');
        $result->flush();

        return $this->redirectToRoute('listbook', [
            'id' => $book->getId()
        ]);
    }

    public function deleteBook($id)
    {
        $result = $this->getDoctrine()->getManager();
        $book = $result->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $result->remove($book);
        $result->flush();
    }
}