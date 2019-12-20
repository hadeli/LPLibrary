<?php


namespace Alexandrie\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Alexandrie\Entity\Reader;

class ReaderController extends AbstractController
{

    public function create()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $reader = new Reader();
        $reader->setFirstName($this->randomName(10));
        $reader->setLastName($this->randomName(10));
        $reader->setEmail($this->randomName(8).'@papa.papa');
        $reader->setBirthDate(new \DateTime());

        $entityManager->persist($reader);
        $entityManager->flush();
        return new JsonResponse(["status" => "Reader entré en base de données"]);

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
        $reader = $this->getDoctrine()->getRepository(Reader::class)->findAll();

        return $this->json($reader);
    }

    public function retrieve($id)
    {
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        return $this->json($reader);
    }

    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $toUpdate = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        if (!$toUpdate) {
            throw $this->createNotFoundException('Not existing for id : ' . $id);
        }

        $reader = new Reader();
        $reader->setLastName($this->randomName(10));
        $reader->setFirstName($this->randomName(10));
        $reader->setBirthDate(new \DateTime());
        $reader->setEmail($this->randomName(8).'@daddy.daddy');

        $entityManager->flush();

        return $this->json(['status' => 'Reader mis à jour']);
    }

    public function delete($id)
    {
        $entityManager = $this->getDoctrine()-> getManager();

        $toDelete = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        $entityManager->remove($toDelete);
        $entityManager->flush();
        return $this->json(['status' => 'Library supprimée']);
    }
}