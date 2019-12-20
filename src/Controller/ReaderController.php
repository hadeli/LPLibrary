<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReaderController extends AbstractController
{
    function list() {
        $readers = $this->getDoctrine()->getRepository(Reader::class)->findAll();
        return $this->json($readers);
    }

    function detail(int $id) {
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        return $this->json($reader);
    }

    function delete(int $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        $entityManager->remove($reader);
        return $this->json($reader);
    }
}