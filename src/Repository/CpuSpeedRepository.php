<?php

namespace App\Repository;

use App\Entity\CpuSpeed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CpuSpeed|null find($id, $lockMode = null, $lockVersion = null)
 * @method CpuSpeed|null findOneBy(array $criteria, array $orderBy = null)
 * @method CpuSpeed[]    findAll()
 * @method CpuSpeed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method CpuSpeed[]    findAllOrderByValue()
 */
class CpuSpeedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CpuSpeed::class);
    }

    /**
    * @return CpuSpeed[]
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
    //  * @return CpuSpeed[] Returns an array of CpuSpeed objects
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
    public function findOneBySomeField($value): ?CpuSpeed
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
