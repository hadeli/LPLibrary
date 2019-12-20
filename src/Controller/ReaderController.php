<?php

namespace App\Controller;

use App\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReaderController extends AbstractController{
    public function readerList(){
        $reader = $this->getDoctrine()->getRepository(Reader::class)->findAll();
        return $this->json($reader);
    }

    public function getReader(Reader $id){
        $readers = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        return $this->json($readers);
    }

    public function deleteReader(Reader $id){
        $readers = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        $this->getDoctrine()->getManager()->remove($readers);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(null);
    }
}