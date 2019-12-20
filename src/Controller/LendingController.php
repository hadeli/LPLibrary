<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Category;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Lending;
use Alexandrie\Entity\Library;
use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Orm\EntityManagerInterface;

class LendingController extends AbstractController
{

    public function create()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $dt = new \DateTime();
        $dtEnd = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dt))."+7 day"));

        $lending = new Lending();
        $lending->setCopy(new Copy());
        $lending->setReader(new Reader());
        $lending->setStartDate($dt);
        $lending->setEndDate($dtEnd);

        $entityManager->persist($lending);
        $entityManager->flush();
        return new JsonResponse(["status" => "Lending entré en base de données"]);

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
        $lendings = $this->getDoctrine()->getRepository(Copy::class)->findAll();

        return $this->json($lendings);
    }

    public function retrieve($id)
    {
        $lending = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        return $this->json($lending);
    }

    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $toUpdate = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        if (!$toUpdate) {
            throw $this->createNotFoundException('Not existing for id : ' . $id);
        }

        $copy = new Copy();
        $tempLib = new Library();
        $tempLib->setName($this->randomName(20));
        $copy->setLibrary($tempLib);
        $tempBook = new Book();
        $tempBook->setName($this->randomName(10));
        $tempBook->setIsbn(substr($tempBook->getName(), 0, 3));
        $tempBook->setCategory(new Category());
        $copy->setBook($tempBook);

        $reader =new Reader();
        $reader->setFirstName($this->randomName(10));
        $reader->setLastName($this->randomName(10));
        $reader->setEmail($this->randomName(7). '@papa.papa');
        $reader->setBirthDate(new \DateTime());

        $lending = new Lending();
        $lending->setReader($reader);
        $lending->setCopy($copy);


        $toUpdate->setReader($reader);
        $toUpdate->setCopy($copy);

        $entityManager->flush();

        return $this->json(['status' => 'Lending mis à jour']);
    }

    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $toDelete = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        $entityManager->remove($toDelete);
        $entityManager->flush();

        return $this->json(['status' => 'Lending supprimé']);
    }
}