<?php


namespace Alexandrie\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Alexandrie\Entity\Copy;
use Symfony\Component\HttpFoundation\Request;

class CopyController extends AbstractController
{

    public function listCopyAction()
    {
        $Copy_list = $this->getDoctrine()->getRepository(Copy::class)->findAll();

        return $this->json([$Copy_list], 200);
    }

    public function listCopyByIdAction($id)
    {
        $Copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        return $this->json($Copy, 200);
    }

    public function deleteCopyByIdAction($id)
    {
        $Copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Copy);
        $entityManager->flush();

        return $this->json($Copy, 204);
    }

    public function addCopy(Request $request)
    {

        $Copy = new Copy();

        $Copy->setBookId($request->get("book_id"));
        $Copy->setLibraryId($request->get("library_id"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Copy); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($Copy, 201);
    }

    public function updateCopy(Request $request, $id)
    {
        $Copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);


        $Copy->setBookId($request->get("book_id"));
        $Copy->setLibraryId($request->get("library_id"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Copy);
        $entityManager->flush();

        return $this->json($Copy, 200);
    }
}