<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Lending;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class RequestsSQLController extends AbstractController
{
    public function getBookLending($id) {
        $sql = "";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }

    public function getBookLibrary($id) {
        $sql = "";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }

    public function getLibraryStocks($id) {
        $sql = "";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }
}