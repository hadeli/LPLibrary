<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Lending;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LendingController extends AbstractController
{
    public function listLending()
    {
        $reader = $this->getDoctrine()
            ->getRepository(Lending::class)
            ->findAll();
        return $this->json($reader);
    }

    public function createLending(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->get('copy_id') != "" && $request->get('reader_id') != "" && $request->get('start_date') != "" && $request->get('end_date') != "")
        {
            $copyId = $request->get('copy_id');
            $readerId = $request->get('reader_id');
            $startDate = DateTime::createFromFormat('Y-m-d', $request->get('start_date'));
            $endDate = DateTime::createFromFormat('Y-m-d', $request->get('end_date'));

        }else
            return new Response("Il est nécessaire de remplir tous les champs pour la création");

        $lending = new Lending(NULL, $copyId, $readerId, $startDate, $endDate);

        $entityManager->persist($lending);
        $entityManager->flush();

        return new Response($this->json($lending));
    }

    public function showLending($id)
    {
        $reader = $this->getDoctrine()
            ->getRepository(Lending::class)
            ->find($id);
        return $this->json($reader);
    }

    public function updateLending(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        if (null !== $request->get('id')) {
            if ($request->get('copy_id') != "") {$reader->setCopyId($request->get('copy_id'));}
            if ($request->get('reader_id') != "") {$reader->setReaderId($request->get('reader_id'));}
            if ($request->get('start_date') != "") {$reader->setStartDate($request->get('start_date'));}
            if ($request->get('end_date') != "") {$reader->setEndDate($request->get('end_date'));}
        }

        $entityManager->persist($reader);
        $entityManager->flush();

        try {
            return new Response($this->json($reader));
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function deleteLending($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this-> getDoctrine()->getRepository(Lending::class)->find($id);

        $entityManager->remove($reader);
        $entityManager->flush();
        return $this->json($reader);
    }
}