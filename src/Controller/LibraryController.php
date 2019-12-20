<?php


namespace Alexandrie\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Alexandrie\Entity\Library;
use Symfony\Component\HttpFoundation\Request;

class LibraryController extends AbstractController
{

    public function listLibraryAction()
    {
        $Library_list = $this->getDoctrine()->getRepository(Library::class)->findAll();

        return $this->json([$Library_list], 200);
    }

    public function listLibraryByIdAction($id)
    {
        $Library = $this->getDoctrine()->getRepository(Library::class)->find($id);

        return $this->json($Library, 200);
    }

    public function deleteLibraryByIdAction($id)
    {
        $Library = $this->getDoctrine()->getRepository(Library::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Library);
        $entityManager->flush();

        return $this->json($Library, 204);
    }

    public function addLibrary(Request $request)
    {

        $Library = new Library();

        $Library->setName($request->get("name"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Library); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($Library, 201);
    }

    public function updateLibrary(Request $request, $id)
    {
        $Library = $this->getDoctrine()->getRepository(Library::class)->find($id);


        $Library->setName($request->get("name"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Library);
        $entityManager->flush();

        return $this->json($Library, 200);
    }
}