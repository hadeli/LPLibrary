<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Category;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    public function categoryList()
    {
        return $this->json($this->getDoctrine()->getRepository(Category::class)->findAll());
    }

    public function getCategory($id)
    {
        return $this->json($this->getDoctrine()->getRepository(Category::class)->find($id));
    }

    public function createCategory(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->get('code') != "" && $request->get('label') != "") {
            $code = $request->get('code');
            $label = $request->get('label');
        }
        else
            new Response("veuillez remplir tous les champs");

        $product = new Category(NULL, $code, $label);
        $entityManager->persist($product);
        $entityManager->flush();
        try{
            return new Response($this->json($product));
        }catch (Exception $exception){
            return new Response($exception->getMessage());
        }
    }

    public function updateCategory(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if (null !== $request->get('id')){
            if ($request->get('name') != "")
                $product->setCode($request->get('code'));
            if ($request->get('isbn') != "")
                $product->setLabel($request->get('label'));
        }
        else
            return new Response("veuillez remplir correctement les champs");
        $entityManager->persist($product);
        $entityManager->flush();
        try{
            return new Response($this->json($product));
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }

    public function deleteCategory($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return new JsonResponse('Category removed');
    }
}