<?php

namespace App\Controller;
use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Serializer\SerializerInterface;

class BookController extends AbstractController
{
    public function bookPutAction(Request $request){
        $book = $this->getDoctrine()->getRepository(Book::class)->findBy(array('id'=>$request->get('id')));
        $book->setName($request->get('name'));
        $book->setIsbn($request->get('isbn'));
        $book->setCategory($request->get('category'));
    }
    public function listBookAction(){
        $book_list = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->json($book_list);
    }
    public function listBookActionById($id){
        $book = $this->getDoctrine()->getRepository(Book::class)->findBy(array('id'=>$id));
        return $this->json($book);
    }
    public function deleteBookById($id){
        $book = $this->getDoctrine()->getRepository(Book::class)->findBy(array('id'=>$id));

        if (!$book) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }

        $book->remove($book);
        $book->flush();

        return($id."deleted");
    }

    public function index(SerializerInterface $serializer)
    {
        // keep reading for usage examples
    }
}