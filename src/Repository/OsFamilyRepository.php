<?php

namespace App\Repository;

use App\Entity\OsFamily;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OsFamily|null find($id, $lockMode = null, $lockVersion = null)
 * @method OsFamily|null findOneBy(array $criteria, array $orderBy = null)
 * @method OsFamily[]    findAll()
 * @method OsFamily[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OsFamilyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OsFamily::class);
    }

    // /**
    //  * @return OsFamily[] Returns an array of OsFamily objects
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
    public function findOneBySomeField($value): ?OsFamily
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
