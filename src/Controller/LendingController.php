<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Lending;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LendingController extends AbstractController {

    public function displayLendings() {
        $repository = $this->getDoctrine()->getRepository(Lending::class);
        return $this->json($repository->findAll());
    }

    public function getLending($id) {
        $repository = $this->getDoctrine()->getRepository(Lending::class);
        return $this->json($repository->find($id));
    }

    public function createLending(Request $request): Response {

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $lending = new Lending();
        $lending->setBookId($request->request->get('book_id'));
        $lending->setLibraryId($request->request->get('library_id'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($lending);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$lending->getId());
    }


    public function update($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $lending = $entityManager->getRepository(Lending::class)->find($id);

        $lending->setBookId($request->request->get('book_id', $lending->getBookId()));
        $lending->setLibraryId($request->request->get('library_id', $lending->getLibraryId()));

        if (!$lending) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $lending->getId()
        ]);
    }

    public function delete($id) {
        $entityManager = $this->getDoctrine()->getManager();

        $lending = $entityManager->getRepository(Lending::class)->find($id);
        if (!$lending) {
            throw $this->createNotFoundException('Aucune copie trouvée pour n°'.$id);
        }

        $entityManager->remove($lending);
        $entityManager->flush();

        return new Response('', [], 200);
    }
}