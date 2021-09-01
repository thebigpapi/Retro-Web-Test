<?php

namespace App\Repository;

use App\Entity\OsFlag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OsFlag|null find($id, $lockMode = null, $lockVersion = null)
 * @method OsFlag|null findOneBy(array $criteria, array $orderBy = null)
 * @method OsFlag[]    findAll()
 * @method OsFlag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OsFlagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OsFlag::class);
    }

    // /**
    //  * @return OsFlag[] Returns an array of OsFlag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OsFlag
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
