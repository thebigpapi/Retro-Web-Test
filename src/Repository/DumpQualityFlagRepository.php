<?php

namespace App\Repository;

use App\Entity\DumpQualityFlag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DumpQualityFlag|null find($id, $lockMode = null, $lockVersion = null)
 * @method DumpQualityFlag|null findOneBy(array $criteria, array $orderBy = null)
 * @method DumpQualityFlag[]    findAll()
 * @method DumpQualityFlag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DumpQualityFlagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DumpQualityFlag::class);
    }

    // /**
    //  * @return DumpQualityFlag[] Returns an array of DumpQualityFlag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DumpQualityFlag
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
