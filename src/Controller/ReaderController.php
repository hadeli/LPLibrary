<?php

namespace App\Controller;
use App\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractControllerr as AbstractControllerrAlias;
use Symfony\Component\Serializer\SerializerInterface;

class ReaderController extends AbstractController
{
    public function listReaderAction(){
        $reader_list = $this->getDoctrine()->getRepository(Reader::class)->findAll();
        return $this->json($reader_list);
    }
    public function listReaderActionById($id){
        $reader = $this->getDoctrine()->getRepository(Reader::class)->findBy(array('id'=>$id));
        return $this->json($reader);
    }
    public function deleteReaderById($id){
        $reader = $this->getDoctrine()->getRepository(Reader::class)->findBy(array('id'=>$id));

        if (!$reader) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }

        $reader->remove($reader);
        $reader->flush();

        return($id."deleted");
    }

    public function index(SerializerInterface $serializer)
    {
        // keep reading for usage examples
    }
}