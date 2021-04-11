<?php

namespace App\Repository;

use App\Entity\ProcessorVoltage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProcessorVoltage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProcessorVoltage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProcessorVoltage[]    findAll()
 * @method ProcessorVoltage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessorVoltageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProcessorVoltage::class);
    }

    // /**
    //  * @return ProcessorVoltage[] Returns an array of ProcessorVoltage objects
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
    public function findOneBySomeField($value): ?ProcessorVoltage
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
