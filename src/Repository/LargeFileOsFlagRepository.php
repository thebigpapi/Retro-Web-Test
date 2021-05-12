<?php

namespace App\Repository;

use App\Entity\LargeFileOsFlag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LargeFileOsFlag|null find($id, $lockMode = null, $lockVersion = null)
 * @method LargeFileOsFlag|null findOneBy(array $criteria, array $orderBy = null)
 * @method LargeFileOsFlag[]    findAll()
 * @method LargeFileOsFlag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LargeFileOsFlagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LargeFileOsFlag::class);
    }

    // /**
    //  * @return LargeFileOsFlag[] Returns an array of LargeFileOsFlag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LargeFileOsFlag
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
