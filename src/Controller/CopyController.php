<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Copy;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CopyController extends AbstractController
{
    public function listCopy()
    {
        $reader = $this->getDoctrine()
            ->getRepository(Copy::class)
            ->findAll();
        return $this->json($reader);
    }

    public function createCopy(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->get('book_id') != "" && $request->get('library_id') != "")
        {
        $bookId = $request->get('book_id');
        $libraryId = $request->get('library_id');


        }else
            return new Response("Il est nécessaire de remplir tous les champs pour la création");

        $copy = new Copy(NULL, $bookId, $libraryId);

        $entityManager->persist($copy);
        $entityManager->flush();

        return new Response($this->json($copy));
    }

    public function showCopy($id)
    {
        $reader = $this->getDoctrine()
            ->getRepository(Copy::class)
            ->find($id);
        return $this->json($reader);
    }

    public function updateCopy(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        if (null !== $request->get('id')) {
            if ($request->get('book_id') != "") {$reader->setBookId($request->get('book_id'));}
            if ($request->get('library_id') != "") {$reader->setLibraryId($request->get('library_id'));}

        }

        $entityManager->persist($reader);
        $entityManager->flush();

        try {
            return new Response($this->json($reader));
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function deleteCopy($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this-> getDoctrine()->getRepository(Copy::class)->find($id);

        $entityManager->remove($reader);
        $entityManager->flush();
        return $this->json($reader);
    }
}