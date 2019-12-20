<?php


namespace Alexandrie\Controller\Library;


use Alexandrie\Entity\Library\Reader;
use Exception;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReaderController extends AbstractController
{
    public function listReaders()
    {
        $readers = $this-> getDoctrine()
            -> getRepository(Reader::class)
            -> findAll();

        try
        {
            return new Response($this-> json($readers));
        }
        catch (Exception $exception)
        {
            return new Response("There was an error");
        }

    }

    public function showReader($id)
    {
        $reader = $this-> getDoctrine()
            -> getRepository(Reader::class)
            -> find($id);

        try
        {
            return new Response($this-> json($reader));
        }
        catch (Exception $exception)
        {
            return new Response("There was an error");
        }

    }

    public function createReader(Request $request): Response
    {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $reader = new Reader();
        if (null !== $request->get('firstName')) {
            if ($request->get('firstName'))
                $reader->setFirstName($request->get('firstName'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('lastName')) {
            if ($request->get('lastName'))
                $reader->setFirstName($request->get('lastName'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('email')) {
            if ($request->get('email'))
                $reader->setFirstName($request->get('email'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('birthDate')) {
            if ($request->get('birthDate'))
                $reader->setBirthDate(DateTime::createFromFormat('Y-m-d', $request->get('birthDate')));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($reader);
        try
        {
            $entityManager-> flush();
            return new Response($this-> json($reader));
        }
        catch (Exception $exception)
        {
            return new Response("There was an error");
        }

    }

    public function updateReader(Request $request, $id): Response
    {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $reader = $this-> getDoctrine()
            -> getRepository(Reader::class)
            -> find($id);

        if (null !== $request->get('firstName')) {
            if ($request->get('firstName'))
                $reader->setFirstName($request->get('firstName'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('lastName')) {
            if ($request->get('lastName'))
                $reader->setFirstName($request->get('lastName'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('email')) {
            if ($request->get('email'))
                $reader->setFirstName($request->get('email'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('birthDate')) {
            if ($request->get('birthDate'))
                $reader->setBirthDate(DateTime::createFromFormat('Y-m-d', $request->get('birthDate')));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($reader);
        $entityManager-> flush();

        try
        {
            return new Response($this-> json($reader));
        }
        catch (Exception $exception)
        {
            return new Response("There was an error");
        }
    }

    public function deleteReader($id)
    {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $reader = $this-> getDoctrine()
            -> getRepository(Reader::class)
            -> find($id);

        $entityManager-> remove($reader);
        try
        {
            $entityManager-> flush();
            return new Response($this-> json($reader));
        }
        catch (Exception $exception)
        {
            return new Response("There was an error");
        }
    }
}