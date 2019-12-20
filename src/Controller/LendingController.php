<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Lending;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LendingController extends AbstractController
{
    public function lendingList()
    {
        return $this->json($this->getDoctrine()->getRepository(Lending::class)->findAll());
    }

    public function getLending($id)
    {
        return $this->json($this->getDoctrine()->getRepository(Lending::class)->find($id));
    }

    public function createLending(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->get('copy_id') != "" && $request->get('reader_id') != "" &&
            $request->get('start_date') != "" && $request->get('end_date') != "") {
            $copy_id = $request->get('copy_id');
            $reader_id = $request->get('reader_id');
            $start_date = DateTime::createFromFormat('Y-m-d', $request->get('start_date'));
            $end_date = DateTime::createFromFormat('Y-m-d', $request->get('end_date'));
        }
        else
            new Response("veuillez remplir tous les champs");

        $product = new Lending(NULL, $copy_id, $reader_id, $start_date, $end_date);
        $entityManager->persist($product);
        $entityManager->flush();
        try{
            return new Response($this->json($product));
        }catch (Exception $exception){
            return new Response($exception->getMessage());
        }
    }

    public function updateLending(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        if (null !== $request->get('id')){
            if ($request->get('copy_id') != "")
                $product->setCopyId($request->get('copy_id'));
            if ($request->get('reader_id') != "")
                $product->setReaderId($request->get('reader_id'));
            if ($request->get('start_date') != "")
                $product->setStartDate($request->get('start_date'));
            if ($request->get('end_date') != "")
                $product->setEndDate($request->get('end_date'));
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

    public function deleteLending($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return new JsonResponse('Lending removed');
    }
}