<?php

namespace App\Repository;

use App\Entity\DramType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DramType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DramType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DramType[]    findAll()
 * @method DramType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DramTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DramType::class);
    }

    // /**
    //  * @return DramType[] Returns an array of DramType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DramType
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
