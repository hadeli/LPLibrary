<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Copy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class CopyController extends AbstractController
{
    public function listCopyAction()
    {
        $copy_list = $this->getDoctrine()->getRepository(Copy::class)->findAll();

        return $this->json($copy_list, 200);
    }

    public function listCopyByIdAction($id)
    {
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        return $this->json($copy, 200);
    }

    public function deleteCopyByIdAction($id)
    {
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($copy);
        $entityManager->flush();

        return $this->json($copy, 204);
    }

    public function createCopyByIdAction(Request $request)
    {
        $book_id = $request->get("book_id");
        $library_id = $request->get("library_id");

        $copy = new Copy();

        $copy->setBookId($book_id);
        $copy->setLibraryId($library_id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($copy); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($copy, 201);
    }

    public function updateCopyAction(Request $request, $id)
    {
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        $book_id = $request->get("book_id");
        $library_id = $request->get("library_id");

        $copy->setBookId($book_id);
        $copy->setLibraryId($library_id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($copy);
        $entityManager->flush();

        return $this->json($copy, 200);
    }
}
