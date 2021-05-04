<?php

namespace App\Repository;

use App\Entity\MotherboardExpansionSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MotherboardExpansionSlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardExpansionSlot|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardExpansionSlot[]    findAll()
 * @method MotherboardExpansionSlot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardExpansionSlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardExpansionSlot::class);
    }

    // /**
    //  * @return MotherboardExpansionSlot[] Returns an array of MotherboardExpansionSlot objects
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
    public function findOneBySomeField($value): ?MotherboardExpansionSlot
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
