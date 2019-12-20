<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Library;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends AbstractController
{
    public function list(){
        return $this->json($this->getDoctrine()->getRepository(Library::class)->findAll(),Response::HTTP_ACCEPTED);
    }

    public function getLibrary($id){
        $library = $this->getDoctrine()->getManager()->getRepository(Library::class)->find($id);
        if($library === NULL){
            return $this->json(array('message'=>'This library does not exist'),Response::HTTP_NOT_FOUND);
        }
        return $this->json($library);
    }

    public function create(Request $request){
        $library = new Library();
        if(!$request->query->get('name')){
            return $this->json(array('message'=>'Please provide a name for the new library'),Response::HTTP_BAD_REQUEST);
        }
        $library->setName($request->query->get('name'));
        $this->getDoctrine()->getManager()->persist($library);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($library,Response::HTTP_CREATED);
    }

    public function edit($id, Request $request){
        /** @var Library $library */
        $library = $this->getDoctrine()->getManager()->getRepository(Library::class)->find($id);
        if($library === NULL){
            return $this->json(array('message'=>'This library does not exist'),Response::HTTP_NOT_FOUND);
        }
        if(!$request->query->get('name')){
            return $this->json(array('message'=>'Please provide a name for the new library'),Response::HTTP_BAD_REQUEST);
        }
        $library->setName($request->query->get('code'));

        $this->getDoctrine()->getManager()->persist($library);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($library,Response::HTTP_CREATED);
    }

    public function delete($id){
        $libraryToRemove = $this->getDoctrine()->getManager()->getRepository(Library::class)->find($id);
        if($libraryToRemove === NULL){
            return $this->json(array('message'=>'This library does not exist'),Response::HTTP_NOT_FOUND);
        }
        try{
            $this->getDoctrine()->getManager()->remove($libraryToRemove);
            $this->getDoctrine()->getManager()->flush();
        }
        catch (ForeignKeyConstraintViolationException $e){
            return $this->json(array('message'=>'You can not delete this library : it is in use in the database'),Response::HTTP_NOT_FOUND);
        }
        return $this->json(array('message'=>'Library successfully deleted.'),Response::HTTP_ACCEPTED);
    }

    public function countLibraryBooks($id){
        /** @var Library $library */
        $library = $this->getDoctrine()->getManager()->getRepository(Library::class)->find($id);
        if($library === NULL){
            return $this->json(array('message'=>'This library does not exist'),Response::HTTP_NOT_FOUND);
        }

        return $this->json(array(
            'number_of_books' => sizeof($this->getDoctrine()->getManager()->getRepository(Copy::class)
                ->findBy(
                    array(
                        'library_id'=>$library->getId()
                    )
                )
            ),
            'library' => $library
        ),Response::HTTP_ACCEPTED);
    }

    public function isBookAvailable($id,$book_id){
        /** @var Library $library */
        $library = $this->getDoctrine()->getManager()->getRepository(Library::class)->find($id);
        if($library === NULL){
            return $this->json(array('message'=>'This library does not exist'),Response::HTTP_NOT_FOUND);
        }

        $stocks = sizeof($this->getDoctrine()->getManager()->getRepository(Copy::class)->findBy(
            array(
                'book_id' => $book_id,
                'library_id'=>$library->getId()
            )
        ));

        return $this->json(array(
            'stocks' => $stocks
        ),Response::HTTP_ACCEPTED);
    }
}