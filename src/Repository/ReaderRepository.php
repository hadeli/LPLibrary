<?php

namespace Alexandrie\Repository;

use Alexandrie\Entity\Reader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Reader|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reader|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reader[]    findAll()
 * @method Reader[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReaderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reader::class);
    }

    // /**
    //  * @return Reader[] Returns an array of Reader objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reader
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
