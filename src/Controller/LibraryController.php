<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends AbstractController
{
    public function getLibraryList() {
        $libraries = $this->getDoctrine()->getRepository(Library::class)->findAll();
        return $this->json($libraries);
    }

    public function getLibrary(int $id) {
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);
        if (is_null($library)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        return $this->json($library);
    }

    public function addLibrary(Request $request) {
        $library = new Library();
        $name = $request->query->get('name');
        $library->setName($name);
        $this->getDoctrine()->getManager()->persist($library);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($library, Response::HTTP_CREATED);
    }

    public function deleteLibrary(int $id) {
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);
        if (is_null($library)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $this->getDoctrine()->getManager()->remove($library);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($library, Response::HTTP_NO_CONTENT);
    }

    public function editLibrary(int $id, Request $request) {
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);
        if (is_null($library)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $name = $request->query->get('name');
        if (isset($name)) $library->setName($name);
        $this->getDoctrine()->getManager()->persist($library);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($library);
    }
}