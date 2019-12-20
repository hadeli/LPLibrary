<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Lending;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LendingController extends AbstractController
{
    public function displayAll(){
        $lendings = $this->getDoctrine()
            ->getRepository(Lending::class)
            ->findAll();
        return $this->json($lendings,200);
    }

    public function display($id){
        $lending = $this->getDoctrine()
            ->getRepository(Lending::class)
            ->find($id);
        if (!$lending){
            throw $this->createNotFoundException(
                "No lendings found with this id : $id"
            );
        }
        return $this->json($lending,200);
    }

    public function delete($id){
        $lending = $this->getDoctrine()
            ->getRepository(Lending::class)
            ->find($id);
        if (!$lending){
            throw $this->createNotFoundException(
                "No lendings found with this id : $id"
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($lending);
        $entityManager->flush();

        return $this->json([], 204);
    }
    public function add(Request $request){
        $manager = $this->getDoctrine()->getManager();
        $copyId = $request->get("copyId");
        $readerId = $request->get("readerId");
        $startDate = $request->get("startDate");
        $endDate = $request->get("endDate");
        $dateFormat = 'Y-m-d';
        try {
            $startDate = DateTime::createFromFormat($dateFormat,$startDate);
            $endDate = DateTime::createFromFormat($dateFormat,$endDate);

            $lending = new Lending($copyId, $readerId, $startDate->format($dateFormat), $endDate->format($dateFormat));
        } catch (\Exception $e) {
            return $this->json("Please enter a valid date format ($dateFormat)",409);
        }

        $manager->persist($lending);
        $manager->flush();

        return $this->json($lending,201);
    }

    public function update(Request $request, int $id) {
        $lending = $this->getDoctrine()
            ->getRepository(Lending::class)
            ->find($id);
        if (!$lending){
            throw $this->createNotFoundException(
                "No lendings found with this id : $id"
            );
        }
        $manager = $this->getDoctrine()->getManager();


        $copyId = $request->get("copyId");
        $readerId = $request->get("readerId");
        $startDate = $request->get("startDate");
        $endDate = $request->get("endDate");

        if ($copyId) {
            $lending->setCopyId($copyId);
        }
        if ($readerId) {
            $lending->setReaderId($readerId);
        }
        $dateFormat = 'Y-m-d';
        try {
            if ($startDate) {

                    $startDate = DateTime::createFromFormat($dateFormat,$startDate);
                    $lending->setStarDate($startDate->format($dateFormat));


            }
            if ($endDate) {
                    $endDate = DateTime::createFromFormat($dateFormat,$startDate);
                    $lending->setEndDate($endDate->format($dateFormat));

            }
        } catch (\Exception $e) {
            return $this->json("Please enter a valid date format ($dateFormat)",409);
        }

        $manager->flush();

        return $this->json($lending,200);

    }

}