<?php

namespace App\Controller;

use App\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LibraryController extends AbstractController{
    public function libraryList(){
        $library = $this->getDoctrine()->getRepository(Library::class)->findAll();
        return $this->json($library);
    }

    public function getLibrary(Library $id){
        $libraries = $this->getDoctrine()->getRepository(Library::class)->find($id);
        return $this->json($libraries);
    }

    public function deleteLibrary(Library $id){
        $libraries = $this->getDoctrine()->getRepository(Library::class)->find($id);
        $this->getDoctrine()->getManager()->remove($libraries);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(null);
    }
}