<?php


namespace Alexandrie\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Alexandrie\Entity\Reader;
use Symfony\Component\HttpFoundation\Request;

class ReaderController extends AbstractController
{

    public function listReaderAction()
    {
        $Reader_list = $this->getDoctrine()->getRepository(Reader::class)->findAll();

        return $this->json([$Reader_list], 200);
    }

    public function listReaderByIdAction($id)
    {
        $Reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        return $this->json($Reader, 200);
    }

    public function deleteReaderByIdAction($id)
    {
        $Reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Reader);
        $entityManager->flush();

        return $this->json($Reader, 204);
    }

    public function addReader(Request $request)
    {

        $Reader = new Reader();

        $Reader->setFirstName($request->get("first_name"));
        $Reader->setBirthDate($request->get("birth_date"));
        $Reader->setEmail($request->get("email"));
        $Reader->setLastName($request->get("last_name"));


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Reader); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($Reader, 201);
    }

    public function updateReader(Request $request, $id)
    {
        $Reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);


        $Reader->setFirstName($request->get("first_name"));
        $Reader->setBirthDate($request->get("birth_date"));
        $Reader->setEmail($request->get("email"));
        $Reader->setLastName($request->get("last_name"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Reader);
        $entityManager->flush();

        return $this->json($Reader, 200);
    }

}