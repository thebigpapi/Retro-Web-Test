<?php

namespace App\Repository;

use App\Entity\MaxRam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MaxRam|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaxRam|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaxRam[]    findAll()
 * @method MaxRam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method MaxRam[]    findAllOrderByValue()
 */
class MaxRamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaxRam::class);
    }

    /**
    * @return MaxRam[] Returns an array of MaxRam objects
    */
    public function findAllOrderByValue()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.value', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return MaxRam[] Returns an array of MaxRam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MaxRam
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
