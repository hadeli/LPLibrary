<?php

namespace Alexandrie\Controller;

use Alexandrie\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryController extends AbstractController
{
    public function list(): JsonResponse
    {
        return $this->json($this->getDoctrine()->getRepository(Category::class)->findAll());
    }

    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $category = new Category();
        $category->setCode($request->request->get('code'));
        $category->setLabel($request->request->get('label'));

        $errors = $validator->validate($category);
        if(count($errors) > 0) return $this->json(['code' => 1, 'message' => (string)$errors], 422);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json($category, 201);
    }

    public function find(int $id): JsonResponse
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if (!$category) return $this->json(['code' => 1, 'message' => 'Catégorie introuvable'], 404);
        return $this->json($category);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($id);

        if (!$category) return $this->json(['code' => 1, 'message' => 'Catégorie introuvable'], 404);

        $category->setCode($request->request->get('code', $category->getCode()));
        $category->setLabel($request->request->get('label', $category->getLabel()));

        try {
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($category);
    }

    public function delete(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($id);

        if (!$category) return $this->json(['code' => 1, 'message' => 'Catégorie introuvable'], 404);

        try {
            $em->remove($category);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json(['code' => 0, 'message' => 'Catégorie supprimée']);
    }
}
