<?php

namespace App\Controller;
use App\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractControllerller as AbstractControllerllerAlias;
use Symfony\Component\Serializer\SerializerInterface;

class LibraryController extends AbstractController
{
    public function listLibraryAction(){
        $library_list = $this->getDoctrine()->getRepository(Library::class)->findAll();
        return $this->json($library_list);
    }
    public function listLibraryActionById($id){
        $library = $this->getDoctrine()->getRepository(Library::class)->findBy(array('id'=>$id));
        return $this->json($library);
    }
    public function deleteLibrarybyId($id){
        $library = $this->getDoctrine()->getRepository(Library::class)->findBy(array('id'=>$id));

        if (!$library) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }

        $library->remove($library);
        $library->flush();

        return($id."deleted");
    }

    public function index(SerializerInterface $serializer)
    {
        // keep reading for usage examples
    }
}