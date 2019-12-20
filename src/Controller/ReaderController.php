<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ReaderController extends AbstractController
{
    public function listReader(){
        $reader_list = $this->getDoctrine()->getRepository(Reader::class)->findAll();
        return $this->json($reader_list);
    }

    public function listReaderById($id){
        $reader_id = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        return $this->json($reader_id);
    }

    public function deleteReaderById($id){
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reader);
        $entityManager->flush();

        return $this->json($reader, 204);
    }

    public function addReaderById(Request $request){

        $reader = new Reader();

        $reader->setFirstName($request->get("first_name"));
        $reader->setLastName($request->get("last_name"));
        $reader->setBirthDate($request->get("birth_date"));
        $reader->setEmail($request->get("email"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reader);
        $entityManager->flush();

        return $this->json($reader, 201);
    }

    public function updateReader(Request $request, $id){
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        $reader->setFirstName($request->get("first_name"));
        $reader->setLastName($request->get("last_name"));
        $reader->setBirthDate($request->get("birth_date"));
        $reader->setEmail($request->get("email"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reader);
        $entityManager->flush();

        return $this->json($reader, 200);
    }

}