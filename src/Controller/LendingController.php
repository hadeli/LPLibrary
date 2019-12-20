<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Lending;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LendingController extends AbstractController
{
    function list() {
        $lendings = $this->getDoctrine()->getRepository(Lending::class)->findAll();
        return $this->json($lendings);
    }

    function detail(int $id) {
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        return $this->json($lending);
    }

    function delete(int $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        $entityManager->remove($lending);
        return $this->json($lending);
    }
}