<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController implements ObjectController {

    public function displayAll() {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->json($category);
    }

    public function display(int $id) {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        if (!$category) {
            return $this->createNotFoundException();
        }
        return $this->json($category,200);
    }

    public function delete(int $id) {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        return $this->json([], 204);
    }

    public function update(Request $request, int $id) {
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

    public function add(Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $code = $request->get("code");
        $label = $request->get("label");
        $category = new Category();
        $category->setCode($code);
        $category->setLabel($label);
        $manager->persist($category);
        $manager->flush();
        return $this->json($category,201);
    }
}