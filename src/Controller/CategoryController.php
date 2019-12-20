<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class CategoryController extends AbstractController
{
    public function listCategoryAction()
    {
        $category_list = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->json($category_list, 200);
    }

    public function listCategoryByIdAction($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        return $this->json($category, 200);
    }

    public function deleteCategoryByIdAction($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->json($category, 204);
    }

    public function createCategoryAction(Request $request)
    {
        $code = $request->get("code");
        $label = $request->get("label");

        $category = new Category();

        $category->setCode($code);
        $category->setLabel($label);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($category, 201);
    }

    public function updateCategoryByIdAction(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $code = $request->get("code");
        $label = $request->get("label");

        $category->setCode($code);
        $category->setLabel($label);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->flush();

        return $this->json($category, 200);
    }
}
