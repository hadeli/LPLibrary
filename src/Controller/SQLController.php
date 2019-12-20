<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class SQLController extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function getReaderByBook($id) : JsonResponse
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r.first_name, r.last_name
                FROM Alexandrie\Entity\Lending l, 
                Alexandrie\Entity\Book b, 
                Alexandrie\Entity\Copy c, 
                Alexandrie\Entity\Reader r
                WHERE r.id = l.reader_id AND l.id = c.library_id AND c.book_id = b.id AND b.id = :id'
        )->setParameter('id', $id);

        return new JsonResponse($query->getResult());
    }

    public function getAvailableByBook($id) : JsonResponse
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT COUNT(b.id)
                FROM Alexandrie\Entity\Copy c,
                Alexandrie\Entity\Book b, 
                Alexandrie\Entity\Library l 
                WHERE b.id = c.book_id AND l.id = c.library_id AND l.id = :id'
        )->setParameter('id', $id);

        return new JsonResponse($query->getResult());
    }

}