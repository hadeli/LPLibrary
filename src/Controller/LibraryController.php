<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LibraryController extends AbstractController implements ObjectController {

    public function displayAll() {
        $library = $this->getDoctrine()
            ->getRepository(Library::class)
            ->findAll();
        return $this->json($library);
    }

    public function display(int $id) {
        $library = $this->getDoctrine()
            ->getRepository(Library::class)
            ->find($id);
        if (!$library) {
            return $this->createNotFoundException();
        }
        return $this->json($library,200);
    }

    public function delete(int $id) {
        $library = $this->getDoctrine()
            ->getRepository(Library::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($library);
        $entityManager->flush();
        return $this->json([], 204);
    }

    public function update(Request $request, int $id) {
        $manager = $this->getDoctrine()->getManager();
        $library = $manager->getRepository(Library::class)->find($id);
        $name = $request->get("name");

        if ($name != null) {
            $library->setName($name);
        }
        $manager->flush();
        return $this->json($library,200);
    }

    public function add(Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $name = $request->get("name");
        $library = new Library();
        $library->setName($name);
        $manager->persist($library);
        $manager->flush();
        return $this->json($library,201);
    }
}