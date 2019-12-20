<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Copy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CopyController extends AbstractController
{
    public function displayAll(){
        $copies = $this->getDoctrine()
            ->getRepository(Copy::class)
            ->findAll();
        return $this->json($copies,200);
    }

    public function display($id){
        $copy = $this->getDoctrine()
            ->getRepository(Copy::class)
            ->find($id);
        if (!$copy){
            throw $this->createNotFoundException(
                "No copies found with this id : $id"
            );
        }
        return $this->json($copy,200);
    }

    public function delete($id){
        $copy = $this->getDoctrine()
            ->getRepository(Copy::class)
            ->find($id);
        if (!$copy){
            throw $this->createNotFoundException(
                "No copies found with this id : $id"
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($copy);
        $entityManager->flush();

        return $this->json([], 204);
    }
    public function add(Request $request){
        $manager = $this->getDoctrine()->getManager();
        $bookId = $request->get("bookId");
        $libraryId = $request->get("libraryId");

        $copy = new Copy($bookId,$libraryId);

        $manager->persist($copy);
        $manager->flush();

        return $this->json($copy,201);
    }

    public function update(Request $request, int $id) {
        $copy = $this->getDoctrine()
            ->getRepository(Copy::class)
            ->find($id);
        if (!$copy){
            throw $this->createNotFoundException(
                "No copies found with this id : $id"
            );
        }
        $manager = $this->getDoctrine()->getManager();

        $bookId = $request->get("label");
        $libraryId = $request->get("code");

        if ($bookId) {
            $copy->setBookId($bookId);
        }
        if ($libraryId) {
            $copy->setLibraryId($libraryId);
        }

        $manager->flush();

        return $this->json($copy,200);

    }

}