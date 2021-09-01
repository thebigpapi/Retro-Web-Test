<?php

namespace App\Repository;

use App\Entity\LargeFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LargeFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method LargeFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method LargeFile[]    findAll()
 * @method LargeFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LargeFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LargeFile::class);
    }

    // /**
    //  * @return LargeFile[] Returns an array of LargeFile objects
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
    public function findOneBySomeField($value): ?LargeFile
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
