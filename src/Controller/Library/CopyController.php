<?php


namespace Alexandrie\Controller\Library;


use Alexandrie\Entity\Library\Copy;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CopyController extends AbstractController
{
    public function listCopies() {
        $copies = $this-> getDoctrine()
            -> getRepository(Copy::class)
            -> findAll();

        try {
            return new Response($this-> json($copies));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }

    public function showCopy($id) {
        $copy = $this-> getDoctrine()
            -> getRepository(Copy::class)
            -> find($id);

        try {
            return new Response($this-> json($copy));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }

    public function createCopy(Request $request) {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $copy = new Copy();
        if (null !== $request->get('bookId')) {
            if ($request->get('bookId'))
                $copy->setLibraryId($request->get('bookId'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('libraryId')) {
            if ($request->get('libraryId'))
                $copy->setBookId($request->get('libraryId'));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($copy);
        try {
            $entityManager-> flush();
            return new Response($this-> json($copy));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function updateCopy(Request $request, $id) {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $copy = $this-> getDoctrine()
            -> getRepository(Copy::class)
            -> find($id);

        if (null !== $request->get('bookId')) {
            if ($request->get('bookId'))
                $copy->setLibraryId($request->get('bookId'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('libraryId')) {
            if ($request->get('libraryId'))
                $copy->setBookId($request->get('libraryId'));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($copy);
        try {
            $entityManager-> flush();
            return new Response($this-> json($copy));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function deleteCopy($id) {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $copy = $this-> getDoctrine()
            -> getRepository(Copy::class)
            -> find($id);

        $entityManager-> remove($copy);
        try {
            $entityManager-> flush();
            return new Response($this-> json($copy));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }
}