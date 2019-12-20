<?php

namespace App\Controller;

use App\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReaderController extends AbstractController{
    public function readerList(){
        $reader = $this->getDoctrine()->getRepository(Reader::class)->findAll();
        return $this->json($reader);
    }
}