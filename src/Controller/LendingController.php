<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Lending;
use Alexandrie\Entity\Reader;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LendingController extends AbstractController
{
    public function get_lending_list(){
        $lending_list = $this->getDoctrine()->getRepository(Lending::class)->findAll();
        return $this->json($lending_list);
    }

    public function get_lending($id){
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        if(is_null($lending))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);
        return $this->json($lending);
    }

    public function put_lending(Request $request){
        $lending = new Lending();

        $copy_id = $request->query->get('copy');
        $reader_id = $request->query->get('reader');
        $start_date = \DateTime::createFromFormat('Y-m-d H:i:s', $request->query->get('start_date'));
        $end_date = \DateTime::createFromFormat('Y-m-d H:i:s', $request->query->get('end_date'));

        /** @var Copy $copy */
        $copy = $this->getDoctrine()->getRepository(Copy::class)->find($copy_id);
        if(is_null($copy))
            return $this->json(array("message" => "copy not found"), Response::HTTP_NOT_FOUND);
        $lending->setCopy($copy);

        /** @var Reader $reader */
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($reader_id);
        if(is_null($reader))
            return $this->json(array("message" => "reader not found"), Response::HTTP_NOT_FOUND);
        $lending->setReader($reader);

        if(!is_bool($start_date))
            $lending->setStartDate($start_date);
        if(!is_bool($end_date))
            $lending->setEndDate($end_date);

        $em = $this->getDoctrine()->getManager();
        $em->persist($lending);
        $em->flush();

        return $this->json($lending, Response::HTTP_CREATED);
    }

    public function patch_lending($id, Request $request){
        $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);
        if(is_null($lending))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);

        $copy_id = $request->query->get('copy');
        $reader_id = $request->query->get('reader');
        $start_date = \DateTime::createFromFormat('Y-m-d H:i:s', $request->query->get('start_date'));
        $end_date = \DateTime::createFromFormat('Y-m-d H:i:s', $request->query->get('end_date'));

        if(isset($copy_id)) {
            /** @var Copy $copy */
            $copy = $this->getDoctrine()->getRepository(Copy::class)->find($copy_id);
            if (is_null($copy))
                return $this->json(array("message" => "copy not found"), Response::HTTP_NOT_FOUND);
            $lending->setCopy($copy);
        }
        if(isset($reader_id)){
            /** @var Reader $reader */
            $reader = $this->getDoctrine()->getRepository(Reader::class)->find($reader_id);
            if(is_null($reader))
                return $this->json(array("message" => "reader not found"), Response::HTTP_NOT_FOUND);
            $lending->setReader($reader);
        }

        if(isset($start_date) && !is_bool($start_date))
            $lending->setStartDate($start_date);
        if(isset($end_date) && !is_bool($end_date))
            $lending->setEndDate($end_date);

        $em = $this->getDoctrine()->getManager();
        $em->persist($lending);
        $em->flush();

        return $this->json($lending);
    }

    public function delete_lending($id){

        try {
            $lending = $this->getDoctrine()->getRepository(Lending::class)->find($id);
            if(is_null($lending))
                return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);

            $em = $this->getDoctrine()->getManager();
            $em->remove($lending);
            $em->flush();

            return $this->json(null, Response::HTTP_NO_CONTENT);

        }catch (ForeignKeyConstraintViolationException $e){
            return $this->json("Erreur lors de la suppresion", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}