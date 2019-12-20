<?php

namespace Alexandrie\Controller;

use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReaderController extends AbstractController
{
    public function index(): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Reader::class);

        return $this->json($repository->findAll());
    }

    public function add(Request $request): JsonResponse
    {
        $reader = new Reader();

        $reader->setFirstName($request->request->get('first_name'));
        $reader->setLastName($request->request->get('last_name'));
        $reader->setBirthDate($request->request->get('birth_date'));
        $reader->setEmail($request->request->get('email'));

        try {
            $em = $this->getDoctrine()->getManager();

            $em->persist($reader);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($reader, 201);
    }

    public function find(int $id): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Reader::class);

        $reader = $repository->find($id);

        if (!$reader) return $this->json(['code' => 1, 'message' => 'Reader introuvable'], 404);

        return $this->json($reader);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $reader = $em->getRepository(Reader::class)->find($id);

        if (!$reader) return $this->json(['code' => 1, 'message' => 'Reader introuvable'], 404);

        $reader->setFirstName($request->request->get('first_name', $reader->getFirstName()));
        $reader->setLastName($request->request->get('last_name', $reader->getLastName()));
        $reader->setBirthDate($request->request->get('birth_date', $reader->getBirthDate()));
        $reader->setEmail($request->request->get('email', $reader->getEmail()));

        try {
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($reader);
    }

    public function delete(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $reader = $em->getRepository(Reader::class)->find($id);

        if (!$reader) return $this->json(['code' => 1, 'message' => 'Reader introuvable'], 404);


        try {
            $em->remove($reader);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json(['code' => 0, 'message' => 'Reader supprimé']);
    }
}
