<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    public function index(): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);

        return $this->json($repository->findAll());
    }

    public function add(Request $request): JsonResponse
    {
        $book = new Book();

        $book->setId($request->request->get('id'));
        $book->setName($request->request->get('name'));
        $book->setIsbn($request->request->get('isbn'));
        $book->setCategoryId($request->request->get('category_id'));

        try {
            $em = $this->getDoctrine()->getManager();

            $em->persist($book);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($book, 201);
    }

    public function find(int $id): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);

        $book = $repository->find($id);

        if (!$book) return $this->json(['code' => 1, 'message' => 'Livre introuvable'], 404);

        return $this->json($book);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Plane::class)->find($id);

        if (!$book) return $this->json(['id' => 1, 'message' => 'Livre introuvable'], 404);

        $book->setId($request->request->get('id', $book->getId()));
        $book->setName($request->request->get('name', $book->getName()));
        $book->setIsbn($request->request->get('isbn'), $book->getIsbn());
        $book->setCategoryId($request->request->get('category_id'), $book->getCategoryId());

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

        return $this->json(['code' => 0, 'message' => 'Categorie supprimé']);
    }
}