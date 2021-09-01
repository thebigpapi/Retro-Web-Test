<?php

namespace App\Repository;

use App\Entity\LargeFileChipset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LargeFileChipset|null find($id, $lockMode = null, $lockVersion = null)
 * @method LargeFileChipset|null findOneBy(array $criteria, array $orderBy = null)
 * @method LargeFileChipset[]    findAll()
 * @method LargeFileChipset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LargeFileChipsetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LargeFileChipset::class);
    }

    // /**
    //  * @return LargeFileChipset[] Returns an array of LargeFileChipset objects
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
    public function findOneBySomeField($value): ?LargeFileChipset
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
