<?php

namespace App\Repository;

use App\Entity\MotherboardImageType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MotherboardImageType|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardImageType|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardImageType[]    findAll()
 * @method MotherboardImageType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardImageTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardImageType::class);
    }

    // /**
    //  * @return MotherboardImageType[] Returns an array of MotherboardImageType objects
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
    public function findOneBySomeField($value): ?MotherboardImageType
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
