<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Copy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class CopyController extends AbstractController
{
    public function listCopy(){
        $list = $this->getDoctrine()->getRepository(Copy::class)->findAll();
        return $this->json($list, 200);
    }

    public function listCopyById($id){
        $result = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        return $this->json($result, 200);
    }
    public function deleteCopy($id) {
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($copy);
        $entityManager->flush();
        return $this->json([], 204);
    }
}