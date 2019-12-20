<?php

namespace Alexandrie\Controller;

use Alexandrie\Entity\Book;
use Alexandrie\Entity\Category;
use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookController extends AbstractController
{
    public function list(): JsonResponse
    {
        return $this->json($this->getDoctrine()->getRepository(Book::class)->findAll());
    }

    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $book = new Book();
        $book->setName($request->request->get('name'));
        $book->setIsbn($request->request->get('isbn'));
        $book->setCategory($em->getRepository(Category::class)->find($request->request->get('category_id')));

        $errors = $validator->validate($book);
        if(count($errors) > 0) return $this->json(['code' => 1, 'message' => (string)$errors], 422);

        try {
            $em->persist($book);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json($book, 201);
    }

    public function find(int $id): JsonResponse
    {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        if (!$book) return $this->json(['code' => 1, 'message' => 'Livre introuvable'], 404);
        return $this->json($book);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) return $this->json(['code' => 1, 'message' => 'Livre introuvable'], 404);

        $book->setName($request->request->get('name', $book->getName()));
        $book->setIsbn($request->request->get('isbn', $book->getIsbn()));
        $book->setCategory($request->request->get('category_id') ? $em->getRepository(Category::class)->find($request->request->get('category_id')) : $book->getCategory());

        try {
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($book);
    }

    public function delete(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) return $this->json(['code' => 1, 'message' => 'Livre introuvable'], 404);

        try {
            $em->remove($book);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json(['code' => 0, 'message' => 'Livre supprimé']);
    }

    public function readers(int $id): JsonResponse
    {
        return $this->json($this->getDoctrine()->getRepository(Reader::class)->getBookReaders($id));
    }
}
