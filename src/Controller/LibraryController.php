<?php


namespace Alexandrie\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Alexandrie\Entity\Library;

class LibraryController extends AbstractController
{

    public function create()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $library = new Library();
        $library->setName($this->randomName(20));

        $entityManager->persist($library);
        $entityManager->flush();
        return new JsonResponse(["status" => "Library entrée en base de données"]);

    }

    private function randomName($times)
    {
        $carac = '0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN';
        $final = '';
        for ($i = 0; $i < 10; $i += 1) {
            $letter = rand(0, strlen($carac) - 1);
            $final .= $carac[$letter];
        }
        return $final;
    }

    public function list()
    {
        $library = $this->getDoctrine()->getRepository(Library::class)->findAll();

        return $this->json($library);
    }

    public function retrieve($id)
    {
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);

        return $this->json($library);
    }

    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $toUpdate = $this->getDoctrine()->getRepository(Library::class)->find($id);

        if (!$toUpdate) {
            throw $this->createNotFoundException('Not existing for id : ' . $id);
        }

        $library = new Library();
        $library->setName($this->randomName(20));

        $entityManager->flush();

        return $this->json(['status' => 'Copy mise à jour']);
    }

    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $toDelete = $this->getDoctrine()->getRepository(Library::class)->find($id);

        $entityManager->remove($toDelete);
        $entityManager->flush();
        return $this->json(['status' => 'Library supprimée']);
    }
}