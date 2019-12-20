<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Lending;
use Alexandrie\Entity\Reader;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LendingController extends AbstractController
{
    public function list(){
        return $this->json($this->getDoctrine()->getRepository(Lending::class)->findAll(),Response::HTTP_ACCEPTED);
    }

    public function getLending($id){
        $lending = $this->getDoctrine()->getManager()->getRepository(Lending::class)->find($id);
        if($lending === NULL){
            return $this->json(array('message'=>'This lending does not exist'),Response::HTTP_NOT_FOUND);
        }
        return $this->json($lending);
    }

    public function create(Request $request){
        $lending = new Lending();

        //On check l'existence de la copie du livre et de l'emprunteur
        if(!$request->query->get('copy_id')){
            return $this->json(array('message'=>'Please provide a copy_id.'),Response::HTTP_BAD_REQUEST);
        }
        if(!$request->query->get('reader_id')){
            return $this->json(array('message'=>'Please provide a reader_id.'),Response::HTTP_BAD_REQUEST);
        }
        /** @var  Copy $book */
        $copy = $this->getDoctrine()->getManager()->getRepository(Copy::class)->find($request->query->get('copy_id'));
        /** @var Reader $library */
        $reader = $this->getDoctrine()->getManager()->getRepository(Reader::class)->find($request->query->get('reader_id'));
        //On check si la catégorie existe bien
        if($copy === NULL){
            return $this->json(array('message'=>'This copy does not exist'),Response::HTTP_NOT_FOUND);
        }
        if($reader === NULL){
            return $this->json(array('message'=>'This reader does not exist'),Response::HTTP_NOT_FOUND);
        }
        $lending->setCopy($copy);
        $lending->setReader($reader);
        $lending->setStartDate($request->query->get('startDate'));
        $lending->setEndDate($request->query->get('endDate'));

        $this->getDoctrine()->getManager()->persist($lending);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($lending,Response::HTTP_CREATED);
    }

    public function edit($id, Request $request){
        /** @var Lending $lending */
        $lending = $this->getDoctrine()->getManager()->getRepository(Lending::class)->find($id);
        if($lending === NULL){
            return $this->json(array('message'=>'This lending does not exist'),Response::HTTP_NOT_FOUND);
        }

        //On check l'existence de la copie du livre et de l'emprunteur
        /** @var  Copy $book */
        if($request->query->get('copy_id')){
            $copy = $this->getDoctrine()->getManager()->getRepository(Copy::class)->find($request->query->get('copy_id'));
            //On check si la catégorie existe bien
            if($copy === NULL){
                return $this->json(array('message'=>'This copy does not exist'),Response::HTTP_NOT_FOUND);
            }
            $lending->setCopy($copy);
        }
        if($request->query->get('reader_id')){
            /** @var Reader $library */
            $reader = $this->getDoctrine()->getManager()->getRepository(Reader::class)->find($request->query->get('reader_id'));

            if($reader === NULL){
                return $this->json(array('message'=>'This reader does not exist'),Response::HTTP_NOT_FOUND);
            }
            $lending->setReader($reader);
        }

        $lending->setStartDate($request->query->get('startDate'));
        $lending->setEndDate($request->query->get('endDate'));

        $this->getDoctrine()->getManager()->persist($lending);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($lending,Response::HTTP_CREATED);
    }

    public function delete($id){
        $lendingToRemove = $this->getDoctrine()->getManager()->getRepository(Lending::class)->find($id);
        if($lendingToRemove === NULL){
            return $this->json(array('message'=>'This lending does not exist'),Response::HTTP_NOT_FOUND);
        }
        try{
            $this->getDoctrine()->getManager()->remove($lendingToRemove);
            $this->getDoctrine()->getManager()->flush();
        }
        catch (ForeignKeyConstraintViolationException $e){
            return $this->json(array('message'=>'You can not delete this lending : it is in use in the database'),Response::HTTP_NOT_FOUND);
        }
        return $this->json(array('message'=>'Lending successfully deleted.'),Response::HTTP_ACCEPTED);
    }
}