<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController {

    public function displayBooks() {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        return $this->json($repository->findAll());
    }

    public function getBook($id) {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        return $this->json($repository->find($id));
    }

    public function createBook(Request $request): Response {

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $book = new Book();
        $book->setName($request->request->get('name'));
        $book->setIsbn($request->request->get('isbn'));
        $book->setCategoryId($request->request->get('category_id'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$book->getId());
    }


    public function update($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        $book->setName($request->request->get('name', $book->getName()));
        $book->setIsbn($request->request->get('isbn', $book->getIsbn()));
        $book->setCategoryId($request->request->get('category_id', $book->getCategoryId()));

        if (!$book) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $book->getId()
        ]);
    }

    public function delete($id) {
        $entityManager = $this->getDoctrine()->getManager();

        $book = $entityManager->getRepository(Book::class)->find($id);
        if (!$book) {
            throw $this->createNotFoundException('Aucun livre trouvé pour n°'.$id);
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return new Response('', [], 200);
    }
}