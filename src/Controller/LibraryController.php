<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LibraryController extends AbstractController
{
    public function index(): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Library::class);

        return $this->json($repository->findAll());
    }


    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $library = new Library();

        $library->setName($request->request->get('name'));

        $errors = $validator->validate($library);
        if(count($errors) > 0) return $this->json(['code' => 1, 'message' => (string)$errors], 422);
        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($library);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($library, 201);
    }


    public function find(int $id): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Library::class);
        $library = $repository->find($id);

        if (!$library) return $this->json(['code' => 1, 'message' => 'Bibliothèque introuvable'], 404);
        return $this->json($library);
    }
    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $library = $em->getRepository(Library::class)->find($id);

        if (!$library) return $this->json(['code' => 1, 'message' => 'Bibliothèque introuvable'], 404);
        $library->setName($request->request->get('name', $library->getName()));

        try {
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json($library);
    }
    public function delete(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $library = $em->getRepository(Library::class)->find($id);
        if (!$library) return $this->json(['code' => 1, 'message' => 'Bibliothèque introuvable'], 404);
        try {
            $em->remove($library);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json(['code' => 0, 'message' => 'Bibliothèque supprimée']);
    }
}