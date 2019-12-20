<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController{

    public function categoryList(){
        $category = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->json($category);
    }

}