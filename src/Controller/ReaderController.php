<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Reader;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReaderController extends AbstractController
{
    public function list(){
        return $this->json($this->getDoctrine()->getRepository(Reader::class)->findAll(),Response::HTTP_ACCEPTED);
    }

    public function getReader($id){
        $reader = $this->getDoctrine()->getManager()->getRepository(Reader::class)->find($id);
        if($reader === NULL){
            return $this->json(array('message'=>'This reader does not exist'),Response::HTTP_NOT_FOUND);
        }
        return $this->json($reader);
    }

    public function create(Request $request){
        $reader = new Reader();
        if(!$request->query->get('email')){
            return $this->json(array('message'=>'Please provide an email for the new reader'),Response::HTTP_BAD_REQUEST);
        }
        if(!$request->query->get('firstName')){
            return $this->json(array('message'=>'Please provide a "firstName" for the new reader'),Response::HTTP_BAD_REQUEST);
        }
        if(!$request->query->get('lastName')){
            return $this->json(array('message'=>'Please provide a "lastName" for the new reader'),Response::HTTP_BAD_REQUEST);
        }
        $reader->setEmail($request->query->get('email'));
        $reader->setBirthDate($request->query->get('birthDate'));
        $reader->setFirstName($request->query->get('firstName'));
        $reader->setLastName($request->query->get('lastName'));

        $this->getDoctrine()->getManager()->persist($reader);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($reader,Response::HTTP_CREATED);
    }

    public function edit($id, Request $request){
        /** @var Reader $reader */
        $reader = $this->getDoctrine()->getManager()->getRepository(Reader::class)->find($id);
        if($reader === NULL){
            return $this->json(array('message'=>'This reader does not exist'),Response::HTTP_NOT_FOUND);
        }
        if($request->query->get('email')){
            $reader->setEmail($request->query->get('email'));
        }
        if($request->query->get('firstName')){
            $reader->setFirstName($request->query->get('firstName'));
        }
        if($request->query->get('lastName')){
            $reader->setLastName($request->query->get('lastName'));
        }
        if($request->query->get('birthDate')){
            $reader->setBirthDate($request->query->get('birthDate'));
        }

        $this->getDoctrine()->getManager()->persist($reader);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($reader,Response::HTTP_CREATED);
    }

    public function delete($id){
        $readerToRemove = $this->getDoctrine()->getManager()->getRepository(Reader::class)->find($id);
        if($readerToRemove === NULL){
            return $this->json(array('message'=>'This reader does not exist'),Response::HTTP_NOT_FOUND);
        }
        try{
            $this->getDoctrine()->getManager()->remove($readerToRemove);
            $this->getDoctrine()->getManager()->flush();
        }
        catch (ForeignKeyConstraintViolationException $e){
            return $this->json(array('message'=>'You can not delete this reader : it is in use in the database'),Response::HTTP_NOT_FOUND);
        }

        return $this->json(array('message'=>'Reader successfully deleted.'),Response::HTTP_ACCEPTED);
    }
}