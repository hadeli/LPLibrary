<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LibraryController extends AbstractController
{
    function list() {
        $librarys = $this->getDoctrine()->getRepository(Library::class)->findAll();
        return $this->json($librarys);
    }

    function detail(int $id) {
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);
        return $this->json($library);
    }

    function delete(int $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);

        $entityManager->remove($library);
        return $this->json($library);
    }
}