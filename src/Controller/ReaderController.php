<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Reader;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ReaderController extends AbstractController
{
    public function displayAll(){
        $readers = $this->getDoctrine()
            ->getRepository(Reader::class)
            ->findAll();
        return $this->json($readers,200);
    }

    public function display($id){
        $reader = $this->getDoctrine()
            ->getRepository(Reader::class)
            ->find($id);
        if (!$reader){
            throw $this->createNotFoundException(
                "No readers found with this id : $id"
            );
        }
        return $this->json($reader,200);
    }

    public function delete($id){
        $reader = $this->getDoctrine()
            ->getRepository(Reader::class)
            ->find($id);
        if (!$reader){
            throw $this->createNotFoundException(
                "No readers found with this id : $id"
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reader);
        $entityManager->flush();

        return $this->json([], 204);
    }
    public function add(Request $request){
        $manager = $this->getDoctrine()->getManager();
        $firstName = $request->get("firstName");
        $lastName = $request->get("lastName");
        $birthDate = $request->get("birthDate");
        $email = $request->get("email");
        $dateFormat = 'Y-m-d';
        try {
            $birthDate = DateTime::createFromFormat($dateFormat,$birthDate);

            $reader = new Reader($firstName, $lastName, $birthDate->format($dateFormat), $email);
        } catch (\Exception $e) {
            return $this->json("Please enter a valid date format ($dateFormat)",409);
        }

        $manager->persist($reader);
        $manager->flush();

        return $this->json($reader,201);
    }

    public function update(Request $request, int $id) {
        $reader = $this->getDoctrine()
            ->getRepository(Reader::class)
            ->find($id);
        if (!$reader){
            throw $this->createNotFoundException(
                "No lendings found with this id : $id"
            );
        }
        $manager = $this->getDoctrine()->getManager();

        $firstName = $request->get("firstName");
        $lastName = $request->get("lastName");
        $birthDate = $request->get("birthDate");
        $email = $request->get("email");

        if ($firstName) {
            $reader->setFirstName($firstName);
        }
        if ($lastName) {
            $reader->setLastName($lastName);
        }
        $dateFormat = 'Y-m-d';
        try {
            if ($birthDate) {

                $birthDate = DateTime::createFromFormat($dateFormat,$birthDate);
                $reader->setBirthDate($birthDate->format($dateFormat));
            }
        } catch (\Exception $e) {
            return $this->json("Please enter a valid date format ($dateFormat)",409);
        }
        if ($email) {
            $reader->setEmail($email);
        }

        $manager->flush();

        return $this->json($reader,200);

    }

}