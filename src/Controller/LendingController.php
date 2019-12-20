<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Lending;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LendingController extends AbstractController
{
    public function listLending(){
        $lending_list = $this->getDoctrine()->getRepository(Lending::class)->findAll();
        return $this->json($lending_list);
    }

    public function listLendingById($id){
        $lending_id = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        return $this->json($lending_id);
    }

    public function deleteLendingById($id){
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($lending);
        $entityManager->flush();

        return $this->json($lending, 204);
    }

    public function addLendingById(Request $request){
        $lending = new Lending();

        $lending->setStartDate($request->get("start_date"));
        $lending->setEndDate($request->get("end_date"));
        $lending->setCopyId($request->get("copy_id"));
        $lending->setReaderId($request->get("reader_id"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lending);
        $entityManager->flush();
        return $this->json($lending, 201);
    }

    public function updateLending(Request $request, $id){
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        $lending->setStartDate($request->get("start_date"));
        $lending->setEndDate($request->get("end_date"));
        $lending->setCopyId($request->get("copy_id"));
        $lending->setReaderId($request->get("reader_id"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lending);
        $entityManager->flush();

        return $this->json($lending, 200);
    }


}