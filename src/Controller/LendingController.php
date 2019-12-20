<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Category;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Lending;
use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LendingController extends AbstractController
{
    public function getLendingList() {
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

    public function addLending(Request $request) {
        $lending = new Lending();
        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');
        $copy_id = $request->query->get('copy');
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($copy_id);
        $reader_id = $request->query->get('reader');
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($reader_id);
        $lending->setStartDate($startDate);
        $lending->setEndDate($endDate);
        $lending->setCopy($copy);
        $lending->setReader($reader);
        $this->getDoctrine()->getManager()->persist($lending);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($lending, Response::HTTP_CREATED);
    }

    public function deleteLending(int $id) {
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        if (is_null($lending)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $this->getDoctrine()->getManager()->remove($lending);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($lending, Response::HTTP_NO_CONTENT);
    }

    public function editLending(int $id, Request $request) {
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        if (is_null($lending)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');
        $copy_id = $request->query->get('copy');
        $reader_id = $request->query->get('reader');
        if (isset($startDate)) $lending->setStartDate($startDate);
        if (isset($endDate)) $lending->setEndDate($endDate);
        if (isset($copy_id)) {
            $copy = $this->getDoctrine()->getRepository(Copy::class)->find($copy_id);
            $lending->setCopy($copy);
        }
        if (isset($reader_id)) {
            $reader = $this->getDoctrine()->getRepository(Reader::class)->find($reader_id);
            $lending->setReader($reader);
        }
        $this->getDoctrine()->getManager()->persist($lending);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($lending);
    }
}