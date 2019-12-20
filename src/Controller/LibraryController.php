<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LibraryController extends AbstractController
{
    public function displayAll(){
        $libraries = $this->getDoctrine()
            ->getRepository(Library::class)
            ->findAll();
        return $this->json($libraries,200);
    }

    public function display($id){
        $library = $this->getDoctrine()
            ->getRepository(Library::class)
            ->find($id);
        if (!$library){
            throw $this->createNotFoundException(
                "No libraries found with this id : $id"
            );
        }
        return $this->json($library,200);
    }

    public function delete($id){
        $library = $this->getDoctrine()
            ->getRepository(Library::class)
            ->find($id);
        if (!$library){
            throw $this->createNotFoundException(
                "No libraries found with this id : $id"
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($library);
        $entityManager->flush();

        return $this->json([], 204);
    }
    public function add(Request $request){
        $manager = $this->getDoctrine()->getManager();
        $name = $request->get("name");

        $library = new Library($name);

        $manager->persist($library);
        $manager->flush();

        return $this->json($library,201);
    }

    public function update(Request $request, int $id) {
        $library = $this->getDoctrine()
            ->getRepository(Library::class)
            ->find($id);
        if (!$library){
            throw $this->createNotFoundException(
                "No lendings found with this id : $id"
            );
        }
        $manager = $this->getDoctrine()->getManager();


        $name = $request->get("name");

        if ($name) {
            $library->setName($name);
        }

        $manager->flush();

        return $this->json($library,200);

    }

}