<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Lending;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class LendingController extends AbstractController
{
    public function listLending()
    {
        $list = $this->getDoctrine()->getRepository(Lending::class)->findAll();
        return $this->json($list, 200);
    }

    public function listLendingById($id)
    {
        $result = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        return $this->json($result, 200);
    }
}