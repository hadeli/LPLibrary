<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Lending;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class LendingController extends AbstractController
{
    public function listLendingAction()
    {
        $lending_list = $this->getDoctrine()->getRepository(Lending::class)->findAll();

        return $this->json($lending_list, 200);
    }

    public function listLendingByIdAction($id)
    {
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        return $this->json($lending, 200);
    }

    public function deleteLendingByIdAction($id)
    {
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($lending);
        $entityManager->flush();

        return $this->json($lending, 204);
    }

    public function createLendingAction(Request $request)
    {
        $copy_id = $request->get("copy_id");
        $reader_id = $request->get("reader_id");
        $start_date = $request->get("start_date");
        $end_date = $request->get("end_date");

        $lending = new Lending();

        $lending->setCopyId($copy_id);
        $lending->setReaderId($reader_id);
        $lending->setStartDate($start_date);
        $lending->setEndDate($end_date);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lending); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($lending, 201);
    }

    public function updateLendingByIdAction(Request $request, $id)
    {
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        $copy_id = $request->get("copy_id");
        $reader_id = $request->get("reader_id");
        $start_date = $request->get("start_date");
        $end_date = $request->get("end_date");

        $lending->setCopyId($copy_id);
        $lending->setReaderId($reader_id);
        $lending->setStartDate($start_date);
        $lending->setEndDate($end_date);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lending);
        $entityManager->flush();

        return $this->json($lending, 200);
    }
}
