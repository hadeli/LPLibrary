<?php

namespace Alexandrie\Controller;

use Alexandrie\Entity\Book;
use Alexandrie\Entity\Library;
use Alexandrie\Entity\Copy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CopyController extends AbstractController
{
    public function list(): JsonResponse
    {
        return $this->json($this->getDoctrine()->getRepository(Copy::class)->findAllJoinedToBookAndLibrary());
    }

    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $copy = new Copy();
        $copy->setBook($em->getRepository(Book::class)->find($request->request->get('book_id')));
        $copy->setLibrary($em->getRepository(Library::class)->find($request->request->get('library_id')));

        $errors = $validator->validate($copy);
        if(count($errors) > 0) return $this->json(['code' => 1, 'message' => (string)$errors], 422);

        try {
            $em->persist($copy);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json($copy, 201);
    }

    public function find(int $id): JsonResponse
    {
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        if (!$copy) return $this->json(['code' => 1, 'message' => 'Copie introuvable'], 404);
        return $this->json($copy);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $copy = $em->getRepository(Copy::class)->find($id);

        if (!$copy) return $this->json(['code' => 1, 'message' => 'Copie introuvable'], 404);

        $copy->setBook($request->request->get('book_id') ? $em->getRepository(Book::class)->find($request->request->get('book_id')) : $copy->getBook());
        $copy->setLibrary($request->request->get('library_id') ? $em->getRepository(Library::class)->find($request->request->get('library_id')) : $copy->getLibrary());

        try {
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($copy);
    }

    public function delete(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $copy = $em->getRepository(Copy::class)->find($id);

        if (!$copy) return $this->json(['code' => 1, 'message' => 'Copie introuvable'], 404);

        try {
            $em->remove($copy);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json(['code' => 0, 'message' => 'Copie supprimée']);
    }
}
