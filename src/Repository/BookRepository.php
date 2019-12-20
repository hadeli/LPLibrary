<?php


namespace Alexandrie\Repository;


use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookRepository extends EntityRepository
{
    public function findBookReaders($id)
    {
        /*$rawSql = "SELECT first_name, last_name ((FROM lending AS l WHERE l.copy_id = c.id) AS readers FROM copy AS c)
                                                                            AS copys FROM book AS b WHERE b.id = ".$id;
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        } catch (DBALException $e) {
            return new JsonResponse("Une erreur est survenue");
        }
        $stmt->execute([]);

        return $stmt->fetchAll();*/
    }
}