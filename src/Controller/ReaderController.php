<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class ReaderController extends AbstractController
{
    public function listReaderAction()
    {
        $reader_list = $this->getDoctrine()->getRepository(Reader::class)->findAll();

        return $this->json($reader_list, 200);
    }

    public function listReaderByIdAction($id)
    {
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        return $this->json($reader, 200);
    }

    public function deleteReaderByIdAction($id)
    {
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reader);
        $entityManager->flush();

        return $this->json($reader, 204);
    }

    public function createReaderAction(Request $request)
    {
        $first_name = $request->get("first_name");
        $last_name = $request->get("last_name");
        $birth_date = $request->get("birth_date");
        $email = $request->get("email");

        $reader = new Reader();

        $reader->setFirstName($first_name);
        $reader->setLastName($last_name);
        $reader->setBirthDate($birth_date);
        $reader->setEmail($email);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reader); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($reader, 201);
    }

    public function updateReaderByIdAction(Request $request, $id)
    {
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        $first_name = $request->get("first_name");
        $last_name = $request->get("last_name");
        $birth_date = $request->get("birth_date");
        $email = $request->get("email");

        $reader->setFirstName($first_name);
        $reader->setLastName($last_name);
        $reader->setBirthDate($birth_date);
        $reader->setEmail($email);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reader);
        $entityManager->flush();

        return $this->json($reader, 200);
    }
}
