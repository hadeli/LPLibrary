<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController {

    public function displayCategorys() {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        return $this->json($repository->findAll());
    }

    public function getCategory($id) {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        return $this->json($repository->find($id));
    }

    public function createCategory(Request $request): Response {

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setCode($request->request->get('code'));
        $category->setLabel($request->request->get('label'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($category);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$category->getId());
    }


    public function update($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(Category::class)->find($id);

        $category->setName($request->request->get('code', $category->getCode()));
        $category->setIsbn($request->request->get('label', $category->getLabel()));

        if (!$category) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $category->getId()
        ]);
    }

    public function delete($id) {
        $entityManager = $this->getDoctrine()->getManager();

        $category = $entityManager->getRepository(Category::class)->find($id);
        if (!$category) {
            throw $this->createNotFoundException('Aucune catégorie trouvée pour n°'.$id);
        }

        $entityManager->remove($category);
        $entityManager->flush();

        return new Response('', [], 200);
    }

}