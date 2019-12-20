<?php

namespace Alexandrie\Controller;

use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LibraryController extends AbstractController
{
    public function list(): JsonResponse
    {
        return $this->json($this->getDoctrine()->getRepository(Library::class)->findAll());
    }

    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $library = new Library();
        $library->setName($request->request->get('name'));

        $errors = $validator->validate($library);
        if(count($errors) > 0) return $this->json(['code' => 1, 'message' => (string)$errors], 422);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($library);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json($library, 201);
    }

    public function find(int $id): JsonResponse
    {
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);

        if (!$library) return $this->json(['code' => 1, 'message' => 'Librarie introuvable'], 404);
        return $this->json($library);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $library = $em->getRepository(Library::class)->find($id);

        if (!$library) return $this->json(['code' => 1, 'message' => 'Librairie introuvable'], 404);

        $library->setName($request->request->get('name', $library->getName()));

        try {
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($library);
    }

    public function delete(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $library = $em->getRepository(Library::class)->find($id);

        if (!$library) return $this->json(['code' => 1, 'message' => 'Librairie introuvable'], 404);

        try {
            $em->remove($library);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json(['code' => 0, 'message' => 'Librairie supprimée']);
    }

    public function books_available(int $id)
    {
        // erf
    }
}
