<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Library;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class LibraryController extends AbstractController
{
    public function listLibrary()
    {
        $list = $this->getDoctrine()->getRepository(Library::class)->findAll();
        return $this->json($list, 200);
    }

    public function listLibraryById($id)
    {
        $result = $this->getDoctrine()->getRepository(Library::class)->find($id);
        return $this->json($result, 200);
    }
}