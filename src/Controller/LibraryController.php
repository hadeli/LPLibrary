<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends AbstractController
{
    public function get_library_list(){
        $library_list = $this->getDoctrine()->getRepository(Library::class)->findAll();
        return $this->json($library_list);
    }
    public function get_library($id){
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);
        if(is_null($library))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);
        return $this->json($library);
    }
    public function put_library(Request $request){
        $library = new Library();

        $name = $request->query->get('name');
        $library->setName($name);

        $em = $this->getDoctrine()->getManager();
        $em->persist($library);
        $em->flush();

        return $this->json($library, Response::HTTP_CREATED);

    }
    public function patch_library($id, Request $request){
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);
        if(is_null($library))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);

        $name = $request->query->get('name');
        if(isset($name))
            $library->setName($name);

        $em = $this->getDoctrine()->getManager();
        $em->persist($library);
        $em->flush();

        return $this->json($library);

    }
    public function delete_library($id){
        $library = $this->getDoctrine()->getRepository(Library::class)->find($id);
        if(is_null($library))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);
        $em = $this->getDoctrine()->getManager();
        $em->remove($library);
        $em->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    public function book_number($id){
        $copy_list = $this->getDoctrine()->getRepository(Copy::class)->findBy(array("library" => $id));
        return $this->json(sizeof($copy_list));
    }

    public function book_disponibility($id_library, $id_book){
        $copy_list = $this->getDoctrine()->getRepository(Copy::class)->findBy(array(
            "library" => $id_library,
            "book" => $id_book
        ));
        if(sizeof($copy_list) > 0)
            return $this->json(array(
                "stock" => sizeof($copy_list),
            ));
        return $this->json(array("Livre non disponible dans cette bibliothèque"));
    }
}