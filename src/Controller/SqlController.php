<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SqlController extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Book::class);
    }

    public function getReaderByBook($id) {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            '
            SELECT bo.name, re.first_name, re.last_name
            FROM Alexandrie\Entity\Book bo 
            JOIN Alexandrie\Entity\Copy co
            JOIN Alexandrie\Entity\Lending le
            JOIN Alexandrie\Entity\Reader re
            WHERE bo.id = :id AND bo.id = co.book_id AND co.id = le.copy_id AND le.reader_id = re.id
            ORDER BY bo.id ASC'
        )->setParameter('id', $id);

        // returns an array of Product objects

        return new JsonResponse($query->getResult());
    }

    public function getBookLibrary($id) {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            '
            SELECT li.name, COUNT(bo.id)
            FROM Alexandrie\Entity\Book bo 
            JOIN Alexandrie\Entity\Copy co
            JOIN Alexandrie\Entity\Library li
            WHERE li.id = :id AND bo.id = co.book_id AND co.library_id = li.id AND co.id NOT IN (
                                                                             SELECT co.id
                                                                             FROM Alexandrie\Entity\Lending le
                                                                             JOIN Alexandrie\Entity\Copy cop
                                                                             JOIN Alexandrie\Entity\Reader re
                                                                             WHERE le.copy_id = cop.id AND re.id = le.reader_id)'
        )->setParameter('id', $id);

        // returns an array of Product objects

        return new JsonResponse($query->getResult());
    }
}