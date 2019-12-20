<?php

namespace App\Controller;

use App\Entity\Lending;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LendingController extends AbstractController{
    public function lendingList(){
        $lending = $this->getDoctrine()->getRepository(Lending::class)->findAll();
        return $this->json($lending);
    }

    public function getLending(Lending $id){
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        return $this->json($lending);
    }

    public function deleteCopy(Lending $id){
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        $this->getDoctrine()->getManager()->remove($lending);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(null);
    }
}