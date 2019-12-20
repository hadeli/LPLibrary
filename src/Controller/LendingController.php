<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Lending;
use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LendingController extends AbstractController {
    public function lendingList() {
        $lendings = $this->getDoctrine()->getRepository(Lending::class)->findAll();
        return $this->json($lendings);
    }

    public function getLending(int $id) {
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        if (is_null($lending)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        return $this->json($lending);
    }

    public function deleteLending(int $id) {
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        if (is_null($lending)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $this->getDoctrine()->getManager()->remove($lending);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    public function addLending(Request $request) {
        $lending = new Lending();
        $start_date = $request->query->get('start_date');
        $end_date = $request->query->get('end_date');
        $copy_id = $request->query->get('copy');
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($copy_id);
        $reader_id = $request->query->get('reader');
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($reader_id);
        $lending->setCopy($copy);
        $lending->setReader($reader);
        $lending->setStartDate($start_date);
        $lending->setEndDate($end_date);
        $this->getDoctrine()->getManager()->persist($lending);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($lending, Response::HTTP_CREATED);
    }
    public function editLending(int $id, Request $request) {
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        if (is_null($lending)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $copy_id = $request->query->get('copy');
        $reader_id = $request->query->get('reader');
        $start_date = $request->query->get('start_date');
        $end_date = $request->query->get('end_date');
        if (isset($copy_id)) {
            $copy = $this->getDoctrine()->getRepository(Copy::class)->find($copy_id);
            $lending->setBook($copy);
        }
        if (isset($reader_id)) {
            $reader = $this->getDoctrine()->getRepository(Reader::class)->find($reader_id);
            $lending->setReader($reader);
        }
        if (isset($start_date)) $lending->setStartDate();
        if (isset($end_date)) $lending->setEndDate();
        $this->getDoctrine()->getManager()->persist($lending);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($lending);
    }
}