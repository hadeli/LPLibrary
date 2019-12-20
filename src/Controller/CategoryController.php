<?php


namespace Alexandrie\Controller;



use Alexandrie\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    public function listCat(){
        $list = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->json($list, 200);
    }

    public function listCatById($id){
        $result = $this->getDoctrine()->getRepository(Category::class)->find($id);
        return $this->json($result, 200);
    }

    public function deleteCat($id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        return $this->json([], 204);
    }

    public function updateCat(Request $request, int $id) {
        $manager = $this->getDoctrine()->getManager();
        $category = $manager->getRepository(Category::class)->find($id);
        $code = $request->get("code");
        $label = $request->get("label");
        if ($code != null) {
            $category->setCode($code);
        }
        if ($label != null) {
            $category->setLabel($label);
        }
        $manager->flush();
        return $this->json($category,200);
    }

    public function addCat(Request $request) {
        $category = new Category();
        $manager = $this->getDoctrine()->getManager();
        $code = $request->get("code");
        $label = $request->get("label");
        $category->setCode($code);
        $category->setLabel($label);
        $manager->persist($category);
        $manager->flush();
        return $this->json($category,201);
    }
}