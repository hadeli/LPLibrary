<?php


namespace Alexandrie\Controller;

use Alexandrie\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends AbstractController
{

    public function create()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setLabel($this->randomName(8));
        $category->setCode(substr($category->getLabel(), 0, 3));

        $entityManager->persist($category);
        $entityManager->flush();
        return new JsonResponse(["status" => "Category entrée en base de données"]);

    }

    private function randomName($times)
    {
        $carac = '0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN';
        $final = '';
        for ($i = 0; $i < 10; $i += 1) {
            $letter = rand(0, strlen($carac) - 1);
            $final .= $carac[$letter];
        }
        return $final;
    }

    public function list()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->json($categories);
    }

    public function retrieve($id)
    {
        $book = $this->getDoctrine()->getRepository(Category::class)->find($id);

        return $this->json($book);
    }

    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $toUpdate = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if (!$toUpdate) {
            throw $this->createNotFoundException('Not existing for id : ' . $id);
        }

        $toUpdate->setLabel($this->randomName(8));
        $toUpdate->setCode($this->randomName(3));

        $entityManager->flush();

        return $this->json(['status' => 'Category mise à jour']);
    }

    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $toDelete = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $entityManager->remove($toDelete);
        $entityManager->flush();
        return $this->json(['status' => 'Category supprimée']);
    }
}
