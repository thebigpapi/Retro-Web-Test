<?php

namespace App\Repository;

use App\Entity\PSUConnector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PSUConnector|null find($id, $lockMode = null, $lockVersion = null)
 * @method PSUConnector|null findOneBy(array $criteria, array $orderBy = null)
 * @method PSUConnector[]    findAll()
 * @method PSUConnector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PSUConnectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PSUConnector::class);
    }

    // /**
    //  * @return PSUConnector[] Returns an array of PSUConnector objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PSUConnector
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
