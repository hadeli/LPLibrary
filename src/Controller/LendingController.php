<?php

namespace App\Controller;

use App\Entity\Lending;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LendingController extends AbstractController{
    public function lendingList(){
        $lending = $this->getDoctrine()->getRepository(Lending::class)->findAll();
        return $this->json($lending);
    }
}