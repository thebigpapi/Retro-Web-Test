<?php

namespace App\Repository;

use App\Entity\ChipImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChipImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChipImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChipImage[]    findAll()
 * @method ChipImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChipImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChipImage::class);
    }

    // /**
    //  * @return ChipImage[] Returns an array of ChipImage objects
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
    public function findOneBySomeField($value): ?ChipImage
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
