<?php

namespace App\Repository;

use App\Entity\CacheRatio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CacheRatio|null find($id, $lockMode = null, $lockVersion = null)
 * @method CacheRatio|null findOneBy(array $criteria, array $orderBy = null)
 * @method CacheRatio[]    findAll()
 * @method CacheRatio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CacheRatioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CacheRatio::class);
    }

    // /**
    //  * @return CacheRatio[] Returns an array of CacheRatio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CacheRatio
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
