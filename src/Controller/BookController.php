<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Lending;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookController extends AbstractController
{
    public function index(): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);

        return $this->json($repository->findAll());
    }


    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $book = new Book();
        $book->setName($request->request->get('name'));
        $book->setCategoryId($request->request->get('category_id'));
        $book->setIsbn($request->request->get('isbn'));
        $errors = $validator->validate($book);

        if(count($errors) > 0) return $this->json(['code' => 1, 'message' => (string)$errors], 422);
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
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) return $this->json(['code' => 1, 'message' => 'Livre introuvable'], 404);
        $book->setName($request->request->get('name', $book->getName()));
        $book->setCategoryId($request->request->get('category_id', $book->getCategoryId()));
        $book->setIsbn($request->request->get('isbn', $book->getIsbn()));

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

    public function findReader(int $id){
        public function findAllReadersForOneBook($book): array
        {
            $entityManager = $this->getEntityManager();

            $query = $entityManager->createQuery(
                'SELECT r.*
            FROM ((reader r JOIN lending l ON r.id = l.reader_id) JOIN copy c ON c.id = l.copy_id) JOIN book b on b.id = c.book_id
            WHERE b.id = :book'
            )->setParameter('book', $book);

            // returns an array of Product objects
            return $query->getResult();

        }

        findAllReadersForOneBook($id);
    }
}