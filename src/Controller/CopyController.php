<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Copy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CopyController extends AbstractController implements ObjectController {

    public function displayAll() {
        $copy = $this->getDoctrine()
            ->getRepository(Copy::class)
            ->findAll();
        return $this->json($copy);
    }

    public function display(int $id) {
        $copy = $this->getDoctrine()
            ->getRepository(Copy::class)
            ->find($id);
        if (!$copy) {
            return $this->createNotFoundException();
        }
        return $this->json($copy,200);
    }

    public function delete(int $id) {
        $copy = $this->getDoctrine()
            ->getRepository(Copy::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($copy);
        $entityManager->flush();
        return $this->json([], 204);
    }

    public function update(Request $request, int $id) {
        $manager = $this->getDoctrine()->getManager();
        $copy = $manager->getRepository(Copy::class)->find($id);
        $bookId = $request->get("bookId");
        $libraryId = $request->get("libraryId");

        if ($bookId != null) {
            $copy->setBookId($bookId);
        }
        if ($libraryId != null) {
            $copy->setLibraryId($libraryId);
        }
        $manager->flush();
        return $this->json($copy,200);
    }

    public function add(Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $bookId = $request->get("bookId");
        $libraryId = $request->get("libraryId");
        $copy = new Copy();
        $copy->setBookId($bookId);
        $copy->setLibraryId($libraryId);
        $manager->persist($copy);
        $manager->flush();
        return $this->json($copy,201);
    }
}