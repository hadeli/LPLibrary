<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Category;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    public function listCategory()
    {
        $reader = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->json($reader);
    }

    public function createCategory(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->get('code') != "" && $request->get('label') != "")
        {
            $code = $request->get('code');
            $label = $request->get('label');


        }else
            return new Response("Il est nécessaire de remplir tous les champs pour la création");

        $category = new Category(NULL, $code, $label);

        $entityManager->persist($category);
        $entityManager->flush();

        return new Response($this->json($category));
    }

    public function showCategory($id)
    {
        $reader = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        return $this->json($reader);
    }

    public function updateCategory(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if (null !== $request->get('id')) {
            if ($request->get('code') != "") {$reader->setCode($request->get('code'));}
            if ($request->get('label') != "") {$reader->setLabel($request->get('label'));}

        }

        $entityManager->persist($reader);
        $entityManager->flush();

        try {
            return new Response($this->json($reader));
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function deleteCategory($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $reader = $this-> getDoctrine()->getRepository(Category::class)->find($id);

        $entityManager->remove($reader);
        $entityManager->flush();
        return $this->json($reader);
    }
}