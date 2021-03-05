<?php

namespace App\Repository;

use App\Entity\ProcessingUnit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProcessingUnit|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProcessingUnit|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProcessingUnit[]    findAll()
 * @method ProcessingUnit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessingUnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProcessingUnit::class);
    }

    // /**
    //  * @return ProcessingUnit[] Returns an array of ProcessingUnit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProcessingUnit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
