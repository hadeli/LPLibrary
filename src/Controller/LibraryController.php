<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class LibraryController extends AbstractController
{
    public function listLibraryAction()
    {
        $library_list = $this->getDoctrine()->getRepository(Library::class)->findAll();

        return $this->json($library_list, 200);
    }

    public function listLibraryByIdAction($id)
    {
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);

        return $this->json($library, 200);
    }

    public function deleteLibraryByIdAction($id)
    {
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($library);
        $entityManager->flush();

        return $this->json($library, 204);
    }

    public function createLibraryAction(Request $request)
    {
        $name = $request->get("name");

        $library = new Library();

        $library->setName($name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($library); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($library, 201);
    }

    public function updateLibraryByIdAction(Request $request, $id)
    {
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);

        $name = $request->get("name");

        $library->setName($name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($library);
        $entityManager->flush();

        return $this->json($library, 200);
    }
}
