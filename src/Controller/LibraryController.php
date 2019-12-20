<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Library;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends AbstractController
{
    public function libraryList()
    {
        return $this->json($this->getDoctrine()->getRepository(Library::class)->findAll());
    }

    public function getLibrary($id)
    {
        return $this->json($this->getDoctrine()->getRepository(Library::class)->find($id));
    }

    public function createLibrary(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->get('name') != "") {
            $name = $request->get('name');
        }
        else
            new Response("veuillez remplir tous les champs");

        $product = new Library(NULL, $name);
        $entityManager->persist($product);
        $entityManager->flush();
        try{
            return new Response($this->json($product));
        }catch (Exception $exception){
            return new Response($exception->getMessage());
        }
    }

    public function updateLibrary(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Library::class)->find($id);
        if (null !== $request->get('id')){
            if ($request->get('name') != "")
                $product->setName($request->get('name'));
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

    public function deleteLibrary($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Library::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return new JsonResponse('Library removed');
    }
}