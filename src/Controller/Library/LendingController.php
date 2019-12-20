<?php


namespace Alexandrie\Controller\Library;


use Alexandrie\Entity\Library\Lending;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LendingController extends AbstractController
{
    public function listLendings() {
        $lendings = $this-> getDoctrine()
            -> getRepository(Lending::class)
            -> findAll();

        try {
            return new Response($this-> json($lendings));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }

    public function showLending($id) {
        $lending = $this-> getDoctrine()
            -> getRepository(Lending::class)
            -> find($id);

        try {
            return new Response($this-> json($lending));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }

    public function createLending(Request $request) {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $lending = new Lending();
        if (null !== $request->get('readerId')) {
            if ($request->get('readerId'))
                $lending->setEndDate($request->get('readerId'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('copyId')) {
            if ($request->get('copyId'))
                $lending->setEndDate($request->get('copyId'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('startDate')) {
            if ($request->get('startDate'))
                $lending->setEndDate($request->get('startDate'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('endDate')) {
            if ($request->get('endDate'))
                $lending->setEndDate($request->get('endDate'));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($lending);
        $entityManager-> flush();

        try {
            return new Response($this-> json($lending));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }

    public function updateLending(Request $request, $id) {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $lending = $this-> getDoctrine()
            -> getRepository(Lending::class)
            -> find($id);

        if (null !== $request->get('readerId')) {
            if ($request->get('readerId'))
                $lending->setEndDate($request->get('readerId'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('copyId')) {
            if ($request->get('copyId'))
                $lending->setEndDate($request->get('copyId'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('startDate')) {
            if ($request->get('startDate'))
                $lending->setEndDate($request->get('startDate'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('endDate')) {
            if ($request->get('endDate'))
                $lending->setEndDate($request->get('endDate'));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($lending);
        try {
            $entityManager-> flush();
            return new Response($this-> json($lending));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }

    public function deleteLending($id) {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $lending = $this-> getDoctrine()
            -> getRepository(Lending::class)
            -> find($id);

        $entityManager-> remove($lending);
        try {
            $entityManager-> flush();
            return new Response($this-> json($lending));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }
}