<?php

namespace Alexandrie\Controller;

use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReaderController extends AbstractController
{
    public function list(): JsonResponse
    {
        return $this->json($this->getDoctrine()->getRepository(Reader::class)->findAll());
    }

    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $reader = new Reader();
        $reader->setFirstName($request->request->get('firstname'));
        $reader->setLastName($request->request->get('lastname'));
        $reader->setBirthDate(\DateTime::createFromFormat('d/m/Y', $request->request->get('birthdate')));
        $reader->setEmail($request->request->get('email'));

        $errors = $validator->validate($reader);
        if(count($errors) > 0) return $this->json(['code' => 1, 'message' => (string)$errors], 422);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reader);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json($reader, 201);
    }

    public function find(int $id): JsonResponse
    {
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);

        if (!$reader) return $this->json(['code' => 1, 'message' => 'Lecteur introuvable'], 404);
        return $this->json($reader);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $reader = $em->getRepository(Reader::class)->find($id);

        if (!$reader) return $this->json(['code' => 1, 'message' => 'Lecteur introuvable'], 404);

        $reader->setFirstName($request->request->get('firstname', $reader->getFirstName()));
        $reader->setLastName($request->request->get('lastname', $reader->getLastName()));
        $reader->setBirthDate($request->request->get('birthdate') ? \DateTime::createFromFormat('d/m/Y', $request->request->get('birthdate')) : $reader->getBirthDate());
        $reader->setEmail($request->request->get('email', $reader->getEmail()));

        try {
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($reader);
    }

    public function delete(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $reader = $em->getRepository(Reader::class)->find($id);

        if (!$reader) return $this->json(['code' => 1, 'message' => 'Lecteur introuvable'], 404);

        try {
            $em->remove($reader);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json(['code' => 0, 'message' => 'Lecteur supprimé']);
    }
}
