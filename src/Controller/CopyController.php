<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Copy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CopyController extends AbstractController
{
    public function index(): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Copy::class);

        return $this->json($repository->findAll());
    }


    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $copy = new Copy();

        $copy->setBookId($request->request->get('book_id'));
        $copy->setLibraryId($request->request->get('library_id'));


        $errors = $validator->validate($copy);
        if(count($errors) > 0) return $this->json(['code' => 1, 'message' => (string)$errors], 422);
        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($copy);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($copy, 201);
    }


    public function find(int $id): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Copy::class);
        $copy = $repository->find($id);

        if (!$copy) return $this->json(['code' => 1, 'message' => 'Exemplaire introuvable'], 404);
        return $this->json($copy);
    }
    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $copy = $em->getRepository(Copy::class)->find($id);

        if (!$copy) return $this->json(['code' => 1, 'message' => 'Catégorie introuvable'], 404);

        $copy->setBookId($request->request->get('book_id', $copy->getBookId()));
        $copy->setLibraryId($request->request->get('library_id', $copy->getLibraryId()));

        try {
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json($copy);
    }
    public function delete(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $copy = $em->getRepository(Copy::class)->find($id);
        if (!$copy) return $this->json(['code' => 1, 'message' => 'Exemplaire introuvable'], 404);
        try {
            $em->remove($copy);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json(['code' => 0, 'message' => 'Exemplaire supprimé']);
    }
}