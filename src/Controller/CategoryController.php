<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    public function displayAll(){
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->json($categories,200);
    }

    public function display($id){
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        if (!$category){
            throw $this->createNotFoundException(
                "No categories found with this id : $id"
            );
        }
        return $this->json($category,200);
    }

    public function delete($id){
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        if (!$category){
            throw $this->createNotFoundException(
                "No categories found with this id : $id"
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->json([], 204);
    }
    public function add(Request $request){
        $manager = $this->getDoctrine()->getManager();
        $code = $request->get("code");
        $label = $request->get("label");

        $category = new Category($code,$label);

        $manager->persist($category);
        $manager->flush();

        return $this->json($category,201);
    }

    public function update(Request $request, int $id) {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        if (!$category){
            throw $this->createNotFoundException(
                "No categories found with this id : $id"
            );
        }
        $manager = $this->getDoctrine()->getManager();

        $code = $request->get("code");
        $label = $request->get("label");

        if ($code) {
            $category->setCode($code);
        }
        if ($label) {
            $category->setLabel($label);
        }

        $manager->flush();

        return $this->json($category,200);

    }

}