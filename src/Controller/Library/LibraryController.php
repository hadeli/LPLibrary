<?php


namespace Alexandrie\Controller\Library;


use Alexandrie\Entity\Library\Library;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends AbstractController
{
    public function listLibraries() {
        $libraries = $this-> getDoctrine()
            -> getRepository(Library::class)
            -> findAll();

        try {
            return new Response($this-> json($libraries));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function showLibrary($id) {
        $library = $this-> getDoctrine()
            -> getRepository(Library::class)
            -> find($id);

        try {
            return new Response($this-> json($library));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function createLibrary(Request $request) {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $library = new Library();
        if (null !== $request->get('name')) {
            if ($request->get('name'))
                $library->setName($request->get('name'));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($library);

        try {
            $entityManager-> flush();
            return new Response($this-> json($library));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function updateLibrary(Request $request, $id) {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $library = $this-> getDoctrine()
            -> getRepository(Library::class)
            -> find($id);

        if (null !== $request->get('name')) {
            if ($request->get('name'))
                $library->setName($request->get('name'));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($library);

        try {
            $entityManager-> flush();
            return new Response($this-> json($library));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function deleteLibrary($id) {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $library = $this-> getDoctrine()
            -> getRepository(Library::class)
            -> find($id);

        $entityManager-> remove($library);

        try {
            $entityManager-> flush();
            return new Response($this-> json($library));
        } catch (Exception $exception) {
            return new Response("There was an error");
        }
    }

    public function numberAvailableBooks($id)
    {

    }

    public function availableBook()
    {

    }
}