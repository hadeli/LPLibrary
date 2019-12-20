<?php

namespace App\Controller;

use App\Entity\Copy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CopyController extends AbstractController{
    public function copyList(){
        $copy = $this->getDoctrine()->getRepository(Copy::class)->findAll();
        return $this->json($copy);
    }
}