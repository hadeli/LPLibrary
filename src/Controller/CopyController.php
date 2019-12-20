<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Library;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CopyController extends AbstractController
{
    public function list(){
        return $this->json($this->getDoctrine()->getRepository(Copy::class)->findAll(),Response::HTTP_ACCEPTED);
    }

    public function getCopy($id){
        $copy = $this->getDoctrine()->getManager()->getRepository(Copy::class)->find($id);
        if($copy === NULL){
            return $this->json(array('message'=>'This copy does not exist'),Response::HTTP_NOT_FOUND);
        }
        return $this->json($copy);
    }

    public function create(Request $request){
        $copy = new Copy();

        if(!$request->query->get('book_id')){
            return $this->json(array('message'=>'Please provide a book_id.'),Response::HTTP_BAD_REQUEST);
        }
        if(!$request->query->get('library_id')){
            return $this->json(array('message'=>'Please provide a library_id.'),Response::HTTP_BAD_REQUEST);
        }

        //On check l'existence du livre et de la librairie
        /** @var  Book $book */
        $book = $this->getDoctrine()->getManager()->getRepository(Book::class)->find($request->query->get('book_id'));
        /** @var Library $library */
        $library = $this->getDoctrine()->getManager()->getRepository(Library::class)->find($request->query->get('library_id'));
        //On check si la catégorie existe bien
        if($book === NULL){
            return $this->json(array('message'=>'This book does not exist'),Response::HTTP_NOT_FOUND);
        }
        if($library === NULL){
            return $this->json(array('message'=>'This library does not exist'),Response::HTTP_NOT_FOUND);
        }
        $copy->setBook($book);
        $copy->setLibrary($library);

        $this->getDoctrine()->getManager()->persist($copy);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($copy,Response::HTTP_CREATED);
    }

    public function edit($id, Request $request){
        /** @var Copy $copy */
        $copy = $this->getDoctrine()->getManager()->getRepository(Copy::class)->find($id);
        if($copy === NULL){
            return $this->json(array('message'=>'This copy does not exist'),Response::HTTP_NOT_FOUND);
        }

        //On check l'existence du livre et de la librairie
        if($request->query->get('copy_id')){
            /** @var  Book $book */
            $book = $this->getDoctrine()->getManager()->getRepository(Book::class)->find($request->query->get('book_id'));
            //On check si le livre existe bien
            if($book === NULL){
                return $this->json(array('message'=>'This book does not exist'),Response::HTTP_NOT_FOUND);
            }
            $copy->setBook($book);
        }
        if($request->query->get('reader_id')){
            /** @var Library $library */
            $library = $this->getDoctrine()->getManager()->getRepository(Library::class)->find($request->query->get('library_id'));

            if($library === NULL){
                return $this->json(array('message'=>'This library does not exist'),Response::HTTP_NOT_FOUND);
            }
            $copy->setLibrary($library);
        }

        $this->getDoctrine()->getManager()->persist($copy);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($copy,Response::HTTP_CREATED);
    }

    public function delete($id){
        $copyToRemove = $this->getDoctrine()->getManager()->getRepository(Copy::class)->find($id);
        if($copyToRemove === NULL){
            return $this->json(array('message'=>'This copy does not exist'),Response::HTTP_NOT_FOUND);
        }
        try{
            $this->getDoctrine()->getManager()->remove($copyToRemove);
            $this->getDoctrine()->getManager()->flush();
        }
        catch (ForeignKeyConstraintViolationException $e){
            return $this->json(array('message'=>'You can not delete this copy : it is in use in the database'),Response::HTTP_NOT_FOUND);
        }
        return $this->json(array('message'=>'Copy successfully deleted.'),Response::HTTP_ACCEPTED);
    }
}