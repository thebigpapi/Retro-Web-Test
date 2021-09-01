<?php

namespace App\Repository;

use App\Entity\MotherboardSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MotherboardSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardSearch[]    findAll()
 * @method MotherboardSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardSearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardSearch::class);
    }

    // /**
    //  * @return MotherboardSearch[] Returns an array of MotherboardSearch objects
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
    public function findOneBySomeField($value): ?MotherboardSearch
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
