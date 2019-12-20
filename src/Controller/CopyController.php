<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CopyController extends AbstractController {
    public function copyList() {
        $copies = $this->getDoctrine()->getRepository(Copy::class)->findAll();
        return $this->json($copies);
    }

    public function getCopy(int $id) {
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        if (is_null($copy)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        return $this->json($copy);
    }

    public function deleteCopy(int $id) {
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        if (is_null($copy)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $this->getDoctrine()->getManager()->remove($copy);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    public function addCopy(Request $request) {
        $copy = new Copy();
        $book_id = $request->query->get('book');
        $book = $this->getDoctrine()->getRepository(Book::class)->find($book_id);
        $library_id = $request->query->get('library');
        $library = $this->getDoctrine()->getRepository(Library::class)->find($library_id);
        $copy->setBook($book);
        $copy->setLibrary($library);
        $this->getDoctrine()->getManager()->persist($copy);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($copy, Response::HTTP_CREATED);
    }
    public function editCopy(int $id, Request $request) {
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        if (is_null($copy)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $book_id = $request->query->get('book');
        $library_id = $request->query->get('library');
        if (isset($book_id)) {
            $book = $this->getDoctrine()->getRepository(Book::class)->find($book_id);
            $copy->setBook($book);
        }
        if (isset($library_id)) {
            $library = $this->getDoctrine()->getRepository(Library::class)->find($library_id);
            $copy->setLibrary($library);
        }
        $this->getDoctrine()->getManager()->persist($copy);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($copy);
    }
}