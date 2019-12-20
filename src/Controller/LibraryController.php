<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Library;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends AbstractController
{
    public function listLibrary()
    {
        $reader = $this->getDoctrine()
            ->getRepository(Library::class)
            ->findAll();
        return $this->json($reader);
    }

    public function createLibrary(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->get('name') != "" )
        {
            $name = $request->get('name');
        }else
            return new Response("Il est nécessaire de remplir tous les champs pour la création");

        $library = new Library(null, "$name");

        $entityManager->persist($library);
        $entityManager->flush();

        return new Response($this->json($library));
    }

    public function showLibrary($id)
    {
        $reader = $this->getDoctrine()
            ->getRepository(Library::class)
            ->find($id);
        return $this->json($reader);
    }

    public function updateLibrary(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this->getDoctrine()->getRepository(Library::class)->find($id);

        if (null !== $request->get('id')) {
            if ($request->get('name') != "") {$reader->setName($request->get('name'));}
        }

        $entityManager->persist($reader);
        $entityManager->flush();

        try {
            return new Response($this->json($reader));
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function deleteLibrary($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this-> getDoctrine()->getRepository(Library::class)->find($id);

        $entityManager->remove($reader);
        $entityManager->flush();
        return $this->json($reader);
    }
}