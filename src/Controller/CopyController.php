<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Copy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CopyController extends AbstractController {

    public function displayCopys() {
        $repository = $this->getDoctrine()->getRepository(Copy::class);
        return $this->json($repository->findAll());
    }

    public function getCopy($id) {
        $repository = $this->getDoctrine()->getRepository(Copy::class);
        return $this->json($repository->find($id));
    }

    public function createCopy(Request $request): Response {

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $copy = new Copy();
        $copy->setBookId($request->request->get('book_id'));
        $copy->setLibraryId($request->request->get('library_id'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($copy);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$copy->getId());
    }


    public function update($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $copy = $entityManager->getRepository(Copy::class)->find($id);

        $copy->setBookId($request->request->get('book_id', $copy->getBookId()));
        $copy->setLibraryId($request->request->get('library_id', $copy->getLibraryId()));

        if (!$copy) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $copy->getId()
        ]);
    }

    public function delete($id) {
        $entityManager = $this->getDoctrine()->getManager();

        $copy = $entityManager->getRepository(Copy::class)->find($id);
        if (!$copy) {
            throw $this->createNotFoundException('Aucune copie trouvée pour n°'.$id);
        }

        $entityManager->remove($copy);
        $entityManager->flush();

        return new Response('', [], 200);
    }
}