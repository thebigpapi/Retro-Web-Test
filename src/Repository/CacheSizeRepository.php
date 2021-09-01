<?php

namespace App\Repository;

use App\Entity\CacheSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CacheSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method CacheSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method CacheSize[]    findAll()
 * @method CacheSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CacheSizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CacheSize::class);
    }
    /**
    * @return CacheSize[] Returns an array of CacheSize objects
    */
    public function findAllOrderByValue()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.value', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return CacheSize[] Returns an array of CacheSize objects
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
    public function findOneBySomeField($value): ?CacheSize
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
