<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CopyController extends AbstractController
{
    public function get_copy_list(){
        $copy_list = $this->getDoctrine()->getRepository(Copy::class)->findAll();
        return $this->json($copy_list);
    }
    public function get_copy($id){
        /** @var Copy $copy */
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        if(is_null($copy))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);
        return $this->json($copy);
    }
    public function put_copy(Request $request){
        $copy = new Copy();

        $book_id = $request->query->get('book');
        $library_id = $request->query->get('library');

        /** @var Book $book */
        $book = $this->getDoctrine()->getRepository(Book::class)->find($book_id);
        if(is_null($book))
            return $this->json(array("message" => "book not found"), Response::HTTP_NOT_FOUND);
        $copy->setBook($book);

        /** @var Library $library */
        $library = $this->getDoctrine()->getRepository(Library::class)->find($library_id);
        if(is_null($library))
            return $this->json(array("message" => "library not found"), Response::HTTP_NOT_FOUND);
        $copy->setLibrary($library);

        $em = $this->getDoctrine()->getManager();
        $em->persist($copy);
        $em->flush();

        return $this->json($copy, Response::HTTP_CREATED);

    }
    public function patch_copy($id, Request $request){
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        if(is_null($copy))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);

        $book_id = $request->query->get('book');
        $library_id = $request->query->get('library');

        if(isset($book_id)){
            /** @var Book $book */
            $book = $this->getDoctrine()->getRepository(Book::class)->find($book_id);
            if(is_null($book))
                return $this->json(array("message" => "book not found"), Response::HTTP_NOT_FOUND);
            $copy->setBook($book);
        }
        if(isset($library_id)){
            /** @var Library $book */
            $library = $this->getDoctrine()->getRepository(Library::class)->find($library_id);
            if(is_null($library))
                return $this->json(array("message" => "library not found"), Response::HTTP_NOT_FOUND);
            $copy->setLibrary($library);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($copy);
        $em->flush();

        return $this->json($copy);

    }
    public function delete_copy($id){
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        if(is_null($copy))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);
        $em = $this->getDoctrine()->getManager();
        $em->remove($copy);
        $em->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}