<?php

namespace Alexandrie\Controller;

use Alexandrie\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    public function listCategory(){
        $category_list = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->json($category_list);
    }

    public function listCategoryById($id){
        $category_id = $this->getDoctrine()->getRepository(Category::class)->find($id);
        return $this->json($category_id);
    }

    public function deleteCategoryById($id){
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->json($category, 204);
    }

    public function addCategoryById(Request $request){
        $category = new Category();

        $category->setCode($request->get("code"));
        $category->setLabel($request->get("label"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->flush();
        return $this->json($category, 201);
    }

    public function updateCategory(Request $request, $id){
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $category->setCode($request->get("code"));
        $category->setLabel($request->get("label"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->flush();

        return $this->json($category, 200);
    }


}