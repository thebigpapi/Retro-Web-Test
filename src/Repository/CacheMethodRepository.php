<?php

namespace App\Repository;

use App\Entity\CacheMethod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CacheMethod|null find($id, $lockMode = null, $lockVersion = null)
 * @method CacheMethod|null findOneBy(array $criteria, array $orderBy = null)
 * @method CacheMethod[]    findAll()
 * @method CacheMethod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CacheMethodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CacheMethod::class);
    }

    // /**
    //  * @return CacheMethod[] Returns an array of CacheMethod objects
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
    public function findOneBySomeField($value): ?CacheMethod
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
