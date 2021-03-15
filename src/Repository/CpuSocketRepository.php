<?php

namespace App\Repository;

use App\Entity\CpuSocket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CpuSocket|null find($id, $lockMode = null, $lockVersion = null)
 * @method CpuSocket|null findOneBy(array $criteria, array $orderBy = null)
 * @method CpuSocket[]    findAll()
 * @method CpuSocket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CpuSocketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CpuSocket::class);
    }

    // /**
    //  * @return CpuSocket[] Returns an array of CpuSocket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CpuSocket
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
