<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Library;
use Alexandrie\Entity\Reader;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReaderController extends AbstractController
{
    public function get_reader_list(){
        $reader_list = $this->getDoctrine()->getRepository(Reader::class)->findAll();
        return $this->json($reader_list);
    }

    public function get_reader($id){
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        if(is_null($reader))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);
        return $this->json($reader);
    }

    public function put_reader(Request $request){
        $reader = new Reader();

        $firstname = $request->query->get('firstname');
        $lastname = $request->query->get('lastname');
        $email = $request->query->get('email');
        $birth = \DateTime::createFromFormat('Y-m-d', $request->query->get('birthdate'));

        $reader->setFirstName($firstname);
        $reader->setLastName($lastname);
        $reader->setEmail($email);
        if(!is_bool($birth))
            $reader->setBirthDate($birth);

        $em = $this->getDoctrine()->getManager();
        $em->persist($reader);
        $em->flush();

        return $this->json($reader, Response::HTTP_CREATED);
    }

    public function patch_reader($id, Request $request){
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        if(is_null($reader))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);

        $firstname = $request->query->get('firstname');
        $lastname = $request->query->get('lastname');
        $email = $request->query->get('email');
        $birth = \DateTime::createFromFormat('Y-m-d', $request->query->get('birthdate'));

        if(isset($firstname))
            $reader->setFirstName($firstname);
        if(isset($lastname))
            $reader->setLastName($lastname);
        if(isset($email))
            $reader->setEmail($email);
        if(isset($birth) && !is_bool($birth))
            $reader->setBirthDate($birth);

        $em = $this->getDoctrine()->getManager();
        $em->persist($reader);
        $em->flush();

        $em = $this->getDoctrine()->getManager();
        $em->persist($reader);
        $em->flush();

        return $this->json($reader);

    }

    public function delete_reader($id){
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        if(is_null($reader))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);
        try {

            $em = $this->getDoctrine()->getManager();
            $em->remove($reader);
            $em->flush();
            return $this->json(null, Response::HTTP_NO_CONTENT);

        }catch (ForeignKeyConstraintViolationException $e){
            return $this->json("Erreur lors de la suppresion, le lecteur a emprunté un livre", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}