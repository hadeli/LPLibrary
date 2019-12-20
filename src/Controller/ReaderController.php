<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Reader;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReaderController extends AbstractController
{
    public function readerList()
    {
        return $this->json($this->getDoctrine()->getRepository(Reader::class)->findAll());
    }

    public function getReader($id)
    {
        return $this->json($this->getDoctrine()->getRepository(Reader::class)->find($id));
    }

    public function createReader(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->get('firstname') != "" && $request->get('lastname') != "" &&
            $request->get('birthdate') != "" && $request->get('email') != "") {
            $firstname = $request->get('firstname');
            $lastname = $request->get('lastname');
            $birthdate = DateTime::createFromFormat('Y-m-d', $request->get('firstname'));
            $email = $request->get('email');
        }
        else
            new Response("veuillez remplir tous les champs");

        $product = new Reader(NULL, $firstname, $lastname, $birthdate, $email);
        $entityManager->persist($product);
        $entityManager->flush();
        try{
            return new Response($this->json($product));
        }catch (Exception $exception){
            return new Response($exception->getMessage());
        }
    }

    public function updateReader(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        if (null !== $request->get('id')){
            if ($request->get('firstname') != "")
                $product->setFirstame($request->get('firstname'));
            if ($request->get('lastname') != "")
                $product->setLastame($request->get('lastname'));
            if ($request->get('birthdate') != "")
                $product->setBirthdate($request->get('birthdate'));
            if ($request->get('email') != "")
                $product->setEmail($request->get('email'));
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

    public function deleteReader($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return new JsonResponse('Reader removed');
    }
}