<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Lending;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LendingController extends AbstractController implements ObjectController {

    public function displayAll() {
        $lending = $this->getDoctrine()
            ->getRepository(Lending::class)
            ->findAll();
        return $this->json($lending);
    }

    public function display(int $id) {
        $lending = $this->getDoctrine()
            ->getRepository(Lending::class)
            ->find($id);
        if (!$lending) {
            return $this->createNotFoundException();
        }
        return $this->json($lending,200);
    }

    public function delete(int $id) {
        $lending = $this->getDoctrine()
            ->getRepository(Lending::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($lending);
        $entityManager->flush();
        return $this->json([], 204);
    }

    public function update(Request $request, int $id) {
        $manager = $this->getDoctrine()->getManager();
        $lending = $manager->getRepository(Lending::class)->find($id);
        $copyId = $request->get("copyId");
        $readerId = $request->get("readerId");
        $startDate = $request->get("startDate");
        $endDate = $request->get("endDate");

        if ($copyId != null) {
            $lending->setCopyId($copyId);
        }
        if ($readerId != null) {
            $lending->setReaderId($readerId);
        }
        if ($startDate != null) {
            try {
                $formatedStartDate = DateTime::createFromFormat("Y-m-d",$startDate);
                $lending->setStartDate($formatedStartDate);
            } catch (\Exception $e) {
                return $this->json("startDate format not correct", 409);
            }
        }
        if ($endDate != null) {
            try {
                $formatedEndDate = DateTime::createFromFormat("Y-m-d",$startDate);;
                $lending->setEndDate($formatedEndDate);
            } catch (\Exception $e) {
                return $this->json("EndDate format not correct", 409);
            }
        }
        $manager->flush();
        return $this->json($lending,200);
    }

    public function add(Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $copyId = $request->get("copyId");
        $readerId = $request->get("readerId");
        $startDate = $request->get("startDate");
        $endDate = $request->get("endDate");
        try {
            $formattedStartDate = DateTime::createFromFormat("Y-m-d",$startDate);
        } catch (\Exception $e) {
            return $this->json("StartDate format not correct", 409);
        }

        try {
            $formattedEndDate = DateTime::createFromFormat("Y-m-d",$endDate);
        } catch (\Exception $e) {
            return $this->json("EndDate format not correct", 409);
        }
        $lending = new Lending();
        $lending->setCopyId($copyId);
        $lending->setReaderId($readerId);
        $lending->setStartDate($formattedStartDate);
        $lending->setEndDate($formattedEndDate);
        $manager->persist($lending);
        $manager->flush();
        return $this->json($lending,201);
    }
}