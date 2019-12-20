<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReaderController extends AbstractController
{
    public function getReaderList() {
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

    public function addReader(Request $request) {
        $reader = new Reader();
        $firstName = $request->query->get('firstName');
        $lastName = $request->query->get('lastName');
        $birthDate = $request->query->get('birthDate');
        $email = $request->query->get('email');
        $reader->setFirstName($firstName);
        $reader->setLastName($lastName);
        $reader->setBirthDate($birthDate);
        $reader->setEmail($email);
        $this->getDoctrine()->getManager()->persist($reader);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($reader, Response::HTTP_CREATED);
    }

    public function deleteReader(int $id) {
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        if (is_null($reader)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $this->getDoctrine()->getManager()->remove($reader);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($reader, Response::HTTP_NO_CONTENT);
    }

    public function editReader(int $id, Request $request) {
        $reader = $this->getDoctrine()->getRepository(Reader::class)->find($id);
        if (is_null($reader)) {
            return $this->json('not found', Response::HTTP_NOT_FOUND);
        }
        $firstName = $request->query->get('firstName');
        $lastName = $request->query->get('lastName');
        $birthDate = $request->query->get('birthDate');
        $email = $request->query->get('email');
        if (isset($firstName)) $reader->setFirstName($firstName);
        if (isset($lastName)) $reader->setLastName($lastName);
        if (isset($birthDate)) $reader->setBirthDate($birthDate);
        if (isset($email)) $reader->setEmail($email);
        $this->getDoctrine()->getManager()->persist($reader);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($reader);
    }
}