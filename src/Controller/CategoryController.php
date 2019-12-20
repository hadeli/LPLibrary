<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Category;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class CategoryController extends AbstractController
{
    public function listCategory()
    {
        $list = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->json($list, 200);
    }

    public function listCategoryById($id)
    {
        $result = $this->getDoctrine()->getRepository(Category::class)->find($id);
        return $this->json($result, 200);
    }
}