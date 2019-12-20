<?php


namespace Alexandrie\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Alexandrie\Entity\Lending;
use Symfony\Component\HttpFoundation\Request;

class LendingController extends AbstractController
{

    public function listLendingAction()
    {
        $Lending_list = $this->getDoctrine()->getRepository(Lending::class)->findAll();

        return $this->json([$Lending_list], 200);
    }

    public function listLendingByIdAction($id)
    {
        $Lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        return $this->json($Lending, 200);
    }

    public function deleteLendingByIdAction($id)
    {
        $Lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Lending);
        $entityManager->flush();

        return $this->json($Lending, 204);
    }

    public function addLending(Request $request)
    {

        $Lending = new Lending();

        $Lending->setCopyId($request->get("copy_id"));
        $Lending->setEndDate($request->get("end_date"));
        $Lending->setStartDate($request->get("end_date"));
        $Lending->setReaderId($request->get("reader_id"));
        $Lending->setName($request->get("name"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Lending); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($Lending, 201);
    }

    public function updateLending(Request $request, $id)
    {
        $Lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);


        $Lending->setCopyId($request->get("copy_id"));
        $Lending->setEndDate($request->get("end_date"));
        $Lending->setStartDate($request->get("end_date"));
        $Lending->setReaderId($request->get("reader_id"));
        $Lending->setName($request->get("name"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Lending);
        $entityManager->flush();

        return $this->json($Lending, 200);
    }
}