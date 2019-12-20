<?php

namespace Alexandrie\Controller;

use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LibraryController extends AbstractController
{
    public function listLibrary(){
        $library_list = $this->getDoctrine()->getRepository(Library::class)->findAll();
        return $this->json($library_list);
    }

    public function listLibraryById($id){
        $library_id = $this->getDoctrine()->getRepository(Library::class)->find($id);
        return $this->json($library_id);
    }

    public function deleteLibraryById($id){
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($library);
        $entityManager->flush();

        return $this->json($library, 204);
    }

    public function addLibraryById(Request $request){

        $library = new Library();

        $library->setName($request->get("name"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($library);
        $entityManager->flush();

        return $this->json($library, 201);
    }

    public function updateLibraryByAction(Request $request, $id){
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);

        $library->setName($request->get("name"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($library);
        $entityManager->flush();

        return $this->json($library, 200);
    }
}