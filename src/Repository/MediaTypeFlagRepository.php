<?php

namespace App\Repository;

use App\Entity\MediaTypeFlag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MediaTypeFlag|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaTypeFlag|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaTypeFlag[]    findAll()
 * @method MediaTypeFlag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaTypeFlagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaTypeFlag::class);
    }

    // /**
    //  * @return MediaTypeFlag[] Returns an array of MediaTypeFlag objects
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
    public function findOneBySomeField($value): ?MediaTypeFlag
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
