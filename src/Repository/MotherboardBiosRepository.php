<?php

namespace App\Repository;

use App\Entity\MotherboardBios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MotherboardBios|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardBios|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardBios[]    findAll()
 * @method MotherboardBios[]    findAllDistinct()
 * @method MotherboardBios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardBiosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardBios::class);
    }

    public function findAllDistinct()
    {
        return $this->createQueryBuilder('m')
            ->groupBy('m.manufacturer')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return MotherboardBios[] Returns an array of MotherboardBios objects
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
    public function findOneBySomeField($value): ?MotherboardBios
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
