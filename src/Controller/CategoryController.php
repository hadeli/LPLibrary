<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController{

    public function categoryList(){
        $category = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->json($category);
    }

    public function getCategory(Category $id){
        $categories = $this->getDoctrine()->getRepository(Category::class)->find($id);
        return $this->json($categories);
    }

    public function deleteCategory(Category $id){
        $categories = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $this->getDoctrine()->getManager()->remove($categories);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(null);
    }

}