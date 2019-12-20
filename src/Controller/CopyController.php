<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Copy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CopyController extends AbstractController
{
    function list() {
        $copys = $this->getDoctrine()->getRepository(Copy::class)->findAll();
        return $this->json($copys);
    }

    function detail(int $id) {
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        return $this->json($copy);
    }

    function delete(int $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        $entityManager->remove($copy);
        return $this->json($copy);
    }
}