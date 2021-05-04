<?php

namespace App\Repository;

use App\Entity\ChipsetBiosCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChipsetBiosCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChipsetBiosCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChipsetBiosCode[]    findAll()
 * @method ChipsetBiosCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChipsetBiosCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChipsetBiosCode::class);
    }

    // /**
    //  * @return ChipsetBiosCode[] Returns an array of ChipsetBiosCode objects
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
    public function findOneBySomeField($value): ?ChipsetBiosCode
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
