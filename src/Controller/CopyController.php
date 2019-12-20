<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Copy;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CopyController extends AbstractController
{
    public function copyList()
    {
        return $this->json($this->getDoctrine()->getRepository(Copy::class)->findAll());
    }

    public function getCopy($id)
    {
        return $this->json($this->getDoctrine()->getRepository(Copy::class)->find($id));
    }

    public function createCopy(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->get('category_id') != "" && $request->get('book_id') != "") {
            $category_id = $request->get('category_id');
            $book_id = $request->get('book_id');
        }
        else
            new Response("veuillez remplir tous les champs");

        $product = new Copy(NULL, $category_id, $book_id);
        $entityManager->persist($product);
        $entityManager->flush();
        try{
            return new Response($this->json($product));
        }catch (Exception $exception){
            return new Response($exception->getMessage());
        }
    }

    public function updateCopy(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        if (null !== $request->get('id')){
            if ($request->get('category_id') != "")
                $product->setName($request->get('category_id'));
            if ($request->get('book_id') != "")
                $product->setIsbn($request->get('book_id'));
        }
        else
            return new Response("veuillez remplir correctement les champs");
        $entityManager->persist($product);
        $entityManager->flush();
        try{
            return new Response($this->json($product));
        }catch (Exception $exception){
            return new Response($exception->getMessage());
        }
    }

    public function deleteCopy($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return new JsonResponse('Copy removed');
    }
}