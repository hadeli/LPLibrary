<?php

namespace Alexandrie\Controller;

use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Reader;
use Alexandrie\Entity\Lending;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LendingController extends AbstractController
{
    public function list(): JsonResponse
    {
        return $this->json($this->getDoctrine()->getRepository(Lending::class)->findAllJoinedToCopyAndReader());
    }

    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $lending = new Lending();
        $lending->setCopy($em->getRepository(Copy::class)->find($request->request->get('copy_id')));
        $lending->setReader($em->getRepository(Reader::class)->find($request->request->get('reader_id')));
        $lending->setStartDate(\DateTime::createFromFormat('d/m/Y', $request->request->get('start_date')));
        $lending->setEndDate(\DateTime::createFromFormat('d/m/Y', $request->request->get('end_date')));


        $errors = $validator->validate($lending);
        if(count($errors) > 0) return $this->json(['code' => 1, 'message' => (string)$errors], 422);

        try {
            $em->persist($lending);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json($lending, 201);
    }

    public function find(int $id): JsonResponse
    {
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);

        if (!$lending) return $this->json(['code' => 1, 'message' => 'Prêt introuvable'], 404);
        return $this->json($lending);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $lending = $em->getRepository(Lending::class)->find($id);

        if (!$lending) return $this->json(['code' => 1, 'message' => 'Prêt introuvable'], 404);

        $lending->setCopy($request->request->get('copy_id') ? $em->getRepository(Copy::class)->find($request->request->get('copy_id')) : $lending->getCopy());
        $lending->setReader($request->request->get('reader_id') ? $em->getRepository(Reader::class)->find($request->request->get('reader_id')) : $lending->getReader());
        $lending->setStartDate($request->request->get('start_date') ? \DateTime::createFromFormat('d/m/Y', $request->request->get('start_date')) : $lending->getStartDate());
        $lending->setEndDate($request->request->get('end_date') ? \DateTime::createFromFormat('d/m/Y', $request->request->get('end_date')) : $lending->getEndDate());

        try {
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($lending);
    }

    public function delete(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $lending = $em->getRepository(Lending::class)->find($id);

        if (!$lending) return $this->json(['code' => 1, 'message' => 'Prêt introuvable'], 404);

        try {
            $em->remove($lending);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json(['code' => 0, 'message' => 'Prêt supprimé']);
    }
}
