<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Copy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CopyController extends AbstractController
{
    public function listCopy(){
        $copy_list = $this->getDoctrine()->getRepository(Copy::class)->findAll();
        return $this->json($copy_list);
    }

    public function listCopyById($id){
        $copy_id = $this->getDoctrine()->getRepository(Copy::class)->find($id);
        return $this->json($copy_id);
    }

    public function deleteCopyById($id){
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($copy);
        $entityManager->flush();

        return $this->json($copy, 204);
    }

    public function addCopyById(Request $request){

        $copy = new Copy();
        $copy->setBookId($request->get("book_id"));
        $copy->setLibraryId($request->get("library_id"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($copy);
        $entityManager->flush();

        return $this->json($copy, 201);
    }

    public function updateCopyBy(Request $request, $id){
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($id);

        $copy->setBookId($request->get("book_id"));
        $copy->setLibraryId($request->get("library_id"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($copy);
        $entityManager->flush();

        return $this->json($copy, 200);
    }


}