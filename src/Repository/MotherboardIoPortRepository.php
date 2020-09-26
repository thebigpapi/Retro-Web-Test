<?php

namespace App\Repository;

use App\Entity\MotherboardIoPort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MotherboardIoPort|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardIoPort|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardIoPort[]    findAll()
 * @method MotherboardIoPort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardIoPortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardIoPort::class);
    }

    // /**
    //  * @return MotherboardIoPort[] Returns an array of MotherboardIoPort objects
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
    public function findOneBySomeField($value): ?MotherboardIoPort
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
