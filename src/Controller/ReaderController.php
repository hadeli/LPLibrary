<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReaderController extends AbstractController {

    public function displayReaders() {
        $repository = $this->getDoctrine()->getRepository(Reader::class);
        return $this->json($repository->findAll());
    }

    public function getReader($id) {
        $repository = $this->getDoctrine()->getRepository(Reader::class);
        return $this->json($repository->find($id));
    }

    public function createReader(Request $request): Response {

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $reader = new Reader();
        $reader->setFirstName($request->request->get('first_name'));
        $reader->setLastName($request->request->get('last_name'));
        $reader->setBirthDate($request->request->get('birth_date'));
        $reader->setEmail($request->request->get('email'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($reader);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$reader->getId());
    }


    public function update($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $entityManager->getRepository(Reader::class)->find($id);

        $reader->setFirstName($request->request->get('first_name', $reader->getFirstName()));
        $reader->setLastName($request->request->get('last_name', $reader->getLastName()));
        $reader->setBirthDate($request->request->get('birth_date', $reader->getBirthDate()));
        $reader->setEmail($request->request->get('email', $reader->getEmail()));

        if (!$reader) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $reader->getId()
        ]);
    }

    public function delete($id) {
        $entityManager = $this->getDoctrine()->getManager();

        $reader = $entityManager->getRepository(Reader::class)->find($id);
        if (!$reader) {
            throw $this->createNotFoundException('Aucune copie trouvée pour n°'.$id);
        }

        $entityManager->remove($reader);
        $entityManager->flush();

        return new Response('', [], 200);
    }

}