<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class ReaderController extends AbstractController
{
    public function listReader(){
        $list = $this->getDoctrine()->getRepository(Reader::class)->findAll();
        return $this->json($list, 200);
    }

    public function listReaderById($id){
        $result = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        return $this->json($result, 200);
    }
}