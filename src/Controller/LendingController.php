<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Lending;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LendingController extends AbstractController
{
    public function index(): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Lending::class);

        return $this->json($repository->findAll());
    }


    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $lending = new Lending();

        $lending->setCopyId($request->request->get('book_id'));
        $lending->setReaderId($request->request->get('library_id'));
        $lending->setStartDate($request->request->get('start_date'));
        $lending->setEndDate($request->request->get('end_date'));


        $errors = $validator->validate($lending);
        if(count($errors) > 0) return $this->json(['code' => 1, 'message' => (string)$errors], 422);
        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lending);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }

        return $this->json($lending, 201);
    }


    public function find(int $id): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Lending::class);
        $lending = $repository->find($id);

        if (!$lending) return $this->json(['code' => 1, 'message' => 'Fiche introuvable'], 404);
        return $this->json($lending);
    }
    public function update(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $lending = $em->getRepository(Lending::class)->find($id);

        if (!$lending) return $this->json(['code' => 1, 'message' => 'Fiche introuvable'], 404);

        $lending->setReaderId($request->request->get('reader_id', $lending->getReaderId()));
        $lending->setCopyId($request->request->get('copy_id', $lending->getCopyId()));
        $lending->setStartDate($request->request->get('start_date', $lending->getStartDate()));
        $lending->setEndDate($request->request->get('end_date', $lending->getEndDate()));

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
        if (!$lending) return $this->json(['code' => 1, 'message' => 'Fiche introuvable'], 404);
        try {
            $em->remove($lending);
            $em->flush();
        } catch(\Exception $e) {
            return $this->json(['code' => 1, 'message' => $e->getMessage()], 400);
        }
        return $this->json(['code' => 0, 'message' => 'Fiche supprimée']);
    }
}