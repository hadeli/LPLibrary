<?php


namespace Alexandrie\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Alexandrie\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{

    public function listCategoryAction()
    {
        $Category_list = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->json([$Category_list], 200);
    }

    public function listCategoryByIdAction($id)
    {
        $Category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        return $this->json($Category, 200);
    }

    public function deleteCategoryByIdAction($id)
    {
        $Category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Category);
        $entityManager->flush();

        return $this->json($Category, 204);
    }

    public function addCategory(Request $request)
    {

        $Category = new Category();

        $Category->setCode($request->get("code"));
        $Category->setLabel($request->get("label"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Category); // Initializes the query.
        $entityManager->flush(); // Executes the query.

        return $this->json($Category, 201);
    }

    public function updateCategory(Request $request, $id)
    {
        $Category = $this->getDoctrine()->getRepository(Category::class)->find($id);


        $Category->setCode($request->get("code"));
        $Category->setLabel($request->get("label"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Category);
        $entityManager->flush();

        return $this->json($Category, 200);
    }
}