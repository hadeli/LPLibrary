<?php

namespace App\Controller;

use App\Entity\Copy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CopyController extends AbstractController{
    public function copyList(){
        $copy = $this->getDoctrine()->getRepository(Copy::class)->findAll();
        return $this->json($copy);
    }

    public function getCopy(Copy $id){
        $copies = $this->getDoctrine()->getRepository(Category::class)->find($id);
        return $this->json($copies);
    }

    public function deleteCopy(Copy $id){
        $copies = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $this->getDoctrine()->getManager()->remove($copies);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(null);
    }
}