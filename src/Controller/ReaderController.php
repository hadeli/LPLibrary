<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReaderController extends AbstractController {
    public function readerList() {
        $readers = $this->getDoctrine()->getRepository(Reader::class)->findAll();
        return $this->json($readers);
    }

    public function getReader(int $id) {
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        if (is_null($reader)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        return $this->json($reader);
    }

    public function deleteReader(int $id) {
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        if (is_null($reader)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $this->getDoctrine()->getManager()->remove($reader);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    public function addReader(Request $request) {
        $reader = new Reader();
        $first_name = $request->query->get('first_name');
        $last_name = $request->query->get('last_name');
        $birth_date = $request->query->get('birth_date');
        $email = $request->query->get('email');
        $first_name->setFirstName($first_name);
        $last_name->setLastName($last_name);
        $birth_date->setBirthDate($birth_date);
        $email->setEmail($email);
        $this->getDoctrine()->getManager()->persist($reader);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($reader, Response::HTTP_CREATED);
    }
    public function editReader(int $id, Request $request) {
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        if (is_null($reader)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $first_name = $request->query->get('first_name');
        $last_name = $request->query->get('last_name');
        $birth_date = $request->query->get('birth_date');
        $email = $request->query->get('email');
        if (isset($first_name)) $reader->setFirstName();
        if (isset($last_name)) $reader->setLastName();
        if (isset($birth_date)) $reader->setBirthDate();
        if (isset($email)) $reader->setEmail();
        $this->getDoctrine()->getManager()->persist($reader);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($reader);
    }
}