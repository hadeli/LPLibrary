<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Copy;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class CopyController extends AbstractController
{
    public function listCopy()
    {
        $list = $this->getDoctrine()->getRepository(Copy::class)->findAll();
        return $this->json($list, 200);
    }

    public function listCopyById($id)
    {
        $result = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        return $this->json($result, 200);
    }
}