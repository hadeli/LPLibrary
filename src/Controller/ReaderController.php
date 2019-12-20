<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Reader;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ReaderController extends AbstractController implements ObjectController {

    public function displayAll() {
        $reader = $this->getDoctrine()
            ->getRepository(Reader::class)
            ->findAll();
        return $this->json($reader);
    }

    public function display(int $id) {
        $reader = $this->getDoctrine()
            ->getRepository(Reader::class)
            ->find($id);
        if (!$reader) {
            return $this->createNotFoundException();
        }
        return $this->json($reader,200);
    }

    public function delete(int $id) {
        $reader = $this->getDoctrine()
            ->getRepository(Reader::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reader);
        $entityManager->flush();
        return $this->json([], 204);
    }

    public function update(Request $request, int $id) {
        $manager = $this->getDoctrine()->getManager();
        $reader = $manager->getRepository(Reader::class)->find($id);
        $firstName = $request->get("firstName");
        $lastName = $request->get("lastName");
        $birthDate = $request->get("birthDate");
        $email = $request->get("email");

        if ($firstName != null) {
            $reader->setFirstName($firstName);
        }
        if ($lastName != null) {
            $reader->setLastName($lastName);
        }
        if ($birthDate != null) {
            try {
                $formatteBirthDate = new DateTime($birthDate);
                $reader->setBirthDate($formatteBirthDate->format('Y-m-d'));
            } catch (\Exception $e) {
                return $this->json("BirthDate format not correct", 409);
            }
        }
        if ($email != null) {
            $reader->setEmail($email);
        }
        $manager->flush();
        return $this->json($reader,200);
    }

    public function add(Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $firstName = $request->get("firstName");
        $lastName = $request->get("lastName");
        $birthDate = $request->get("birthDate");
        $email = $request->get("email");
        try {
            $formatteBirthDate = new DateTime($birthDate);
        } catch (\Exception $e) {
            return $this->json("BirthDate format not correct", 409);
        }
        $reader = new Reader();
        $reader->setFirtName($firstName);
        $reader->setLastName($lastName);
        $reader->setBirthDate($formatteBirthDate->format('Y-m-d'));
        $reader->setEmail($email);
        $manager->persist($reader);
        $manager->flush();
        return $this->json($reader,201);
    }
}