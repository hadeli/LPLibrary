<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends AbstractController {

    public function displayLibrarys() {
        $repository = $this->getDoctrine()->getRepository(Library::class);
        return $this->json($repository->findAll());
    }

    public function getLibrary($id) {
        $repository = $this->getDoctrine()->getRepository(Library::class);
        return $this->json($repository->find($id));
    }

    public function createLibrary(Request $request): Response {

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $library = new Library();
        $library->setName($request->request->get('name'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($library);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$library->getId());
    }


    public function update($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $library = $entityManager->getRepository(Library::class)->find($id);

        $library->setName($request->request->get('name', $library->getName()));

        if (!$library) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $library->getId()
        ]);
    }

    public function delete($id) {
        $entityManager = $this->getDoctrine()->getManager();

        $lending = $entityManager->getRepository(Library::class)->find($id);
        if (!$lending) {
            throw $this->createNotFoundException('Aucune librairie trouvée pour n°'.$id);
        }

        $entityManager->remove($lending);
        $entityManager->flush();

        return new Response('', [], 200);
    }

}