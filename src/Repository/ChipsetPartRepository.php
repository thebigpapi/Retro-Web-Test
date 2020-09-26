<?php

namespace App\Repository;

use App\Entity\ChipsetPart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChipsetPart|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChipsetPart|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChipsetPart[]    findAll()
 * @method ChipsetPart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChipsetPartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChipsetPart::class);
    }

    // /**
    //  * @return ChipsetPart[] Returns an array of ChipsetPart objects
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
    public function findOneBySomeField($value): ?ChipsetPart
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
