<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    function list() {
        $categorys = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->json($categorys);
    }

    function detail(int $id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        return $this->json($category);
    }

    function delete(int $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $entityManager->remove($category);
        return $this->json($category);
    }
}