<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReaderController extends AbstractController
{
    public function index(): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Reader::class);

        return $this->json($repository->findAll());
    }


    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $library = new Reader();

        $library->setFirstName($request->request->get('first_name'));
        $library->setLastName($request->request->get('last_name'));
        $library->setBirthDate($request->request->get('birth_date'));
        $library->setEmail($request->request->get('email'));

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
        $repository = $this->getDoctrine()->getRepository(Reader::class);
        $library = $repository->find($id);

        if (!$library) return $this->json(['code' => 1, 'message' => 'Lecteur introuvable'], 404);
        return $this->json($library);
    }
    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $library = $em->getRepository(Reader::class)->find($id);

        if (!$library) return $this->json(['code' => 1, 'message' => 'Lecteur introuvable'], 404);
        $library->setFirstName($request->request->get('first_name', $library->getFirstName()));
        $library->setLastName($request->request->get('last_name', $library->getLastName()));
        $library->setBirth($request->request->get('birth_date', $library->getBirthDate()));
        $library->setEmail($request->request->get('email', $library->getEmail()));

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
        $library = $em->getRepository(Reader::class)->find($id);
        if (!$library) return $this->json(['code' => 1, 'message' => 'Lecteur introuvable'], 404);
        try {
            $em->remove($library);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json(['code' => 0, 'message' => 'Lecteur supprimé']);
    }
}