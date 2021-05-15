<?php

namespace App\Repository;

use App\Entity\LargeFileMotherboard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LargeFileMotherboard|null find($id, $lockMode = null, $lockVersion = null)
 * @method LargeFileMotherboard|null findOneBy(array $criteria, array $orderBy = null)
 * @method LargeFileMotherboard[]    findAll()
 * @method LargeFileMotherboard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LargeFileMotherboardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LargeFileMotherboard::class);
    }

    // /**
    //  * @return LargeFileMotherboard[] Returns an array of LargeFileMotherboard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LargeFileMotherboard
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
