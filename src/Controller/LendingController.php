<?php

namespace App\Controller;
use App\Entity\Lending;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class LendingController extends AbstractController
{
    public function listLendingAction(){
        $lending_list = $this->getDoctrine()->getRepository(Lending::class)->findAll();
        return $this->json($lending_list);
    }
    public function listLendingActionById($id){
        $lending = $this->getDoctrine()->getRepository(Lending::class)->findBy(array('id'=>$id));
        return $this->json($lending);
    }
    public function deleteLendingbyId($id){
        $lending = $this->getDoctrine()->getRepository(Lending::class)->findBy(array('id'=>$id));

        if (!$lending) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }

        $lending->remove($lending);
        $lending->flush();

        return($id."deleted");
    }

    public function index(SerializerInterface $serializer)
    {
        // keep reading for usage examples
    }
}