<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Reader;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReaderController extends AbstractController
{

    public function listReader()
    {
        $reader = $this->getDoctrine()
            ->getRepository(Reader::class)
            ->findAll();
        return $this->json($reader);
    }

    public function createReader(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->get('first_name') != "" && $request->get('last_name') != "" && $request->get('birth_date') != "" && $request->get('email') != "")
        {
            $firstName = $request->get('first_name');
            $lastName = $request->get('last_name');
            $birthDateString = $request->get('birth_date');
            $birthDate = new DateTime($birthDateString);
            $email = $request->get('email');
        }else
            return new Response("Il est nécessaire de remplir tous les champs pour la création");



        $reader = new Reader(null, $firstName, $lastName, $birthDate, $email);
        //$reader = new Reader(1, "Morgan", "Corre", new DateTime(), "morganCorre@wesh.fr");

        $entityManager->persist($reader);
        $entityManager->flush();

        return new Response($this->json($reader));
    }

    public function showReader($id)
    {
        $reader = $this->getDoctrine()
            ->getRepository(Reader::class)
            ->find($id);
        return $this->json($reader);
    }

    public function updateReader(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        if (null !== $request->get('id')) {
            if ($request->get('first_name') != "") {$reader->setFirstName($request->get('first_name'));}
            if ($request->get('last_name') != "") {$reader->setLastName($request->get('last_name'));}
            if ($request->get('birth_date') != "") {$reader->setBirthDate($request->get('birth_date'));}
            if ($request->get('email') != "") {$reader->setEmail($request->get('email'));}
        }

        $entityManager->persist($reader);
        $entityManager->flush();

        try {
            return new Response($this->json($reader));
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function deleteReader($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this-> getDoctrine()->getRepository(Reader::class)->find($id);

        $entityManager->remove($reader);
        $entityManager->flush();
        return $this->json($reader);
    }
}