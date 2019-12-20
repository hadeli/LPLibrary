<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController {

    public function categoryList() {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->json($categories);
    }

    public function getCategory(int $id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if (is_null($category)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        return $this->json($category);
    }

    public function deleteCategory(int $id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if (is_null($category)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $this->getDoctrine()->getManager()->remove($category);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    public function addCategory(Request $request) {
        $category = new Category();
        $code = $request->query->get('code');
        $label = $request->query->get('label');
        $category->setCode($code);
        $category->setLabel($label);
        $this->getDoctrine()->getManager()->persist($category);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($category, Response::HTTP_CREATED);
    }
    public function editCategory(int $id, Request $request) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if (is_null($category)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $code = $request->query->get('code');
        $label = $request->query->get('label');
        if (isset($code)) $category->setCode();
        if (isset($label)) $category->setLabel();
        $this->getDoctrine()->getManager()->persist($category);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($category);
    }
}