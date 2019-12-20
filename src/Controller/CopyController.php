<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Copy;
use Doctrine\ORM\EntityManagerInterface;
use Alexandrie\Entity\Book;
use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CopyController extends AbstractController
{

    public function create()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $copy = new Copy();
        $copy->setBook(new Book());
        $copy->setLibrary(new Library());

        $entityManager->persist($copy);
        $entityManager->flush();
        return new JsonResponse(["status" => "Category entrée en base de données"]);

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
        $categories = $this->getDoctrine()->getRepository(Copy::class)->findAll();

        return $this->json($categories);
    }

    public function retrieve($id)
    {
        $book = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        return $this->json($book);
    }

    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $toUpdate = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        if (!$toUpdate) {
            throw $this->createNotFoundException('Not existing for id : ' . $id);
        }

        $book = new Book();
        $book->setName($this->randomName(10));
        $book->setIsbn($this->randomName(5));

        $library = new Library();
        $library->setName($this->randomName(20));

        $toUpdate->setBook($book);
        $toUpdate->setLibrary($library);

        $entityManager->flush();

        return $this->json(['status' => 'Copy mise à jour']);
    }

    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $toDelete = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        $entityManager->remove($toDelete);
        $entityManager->flush();

        return $this->json(['status' => 'Copy supprimée']);
    }
}