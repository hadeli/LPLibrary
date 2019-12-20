<?php

namespace App\Controller;

use App\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LibraryController extends AbstractController{
    public function libraryList(){
        $library = $this->getDoctrine()->getRepository(Library::class)->findAll();
        return $this->json($library);
    }
}