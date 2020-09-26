<?php

namespace App\Repository;

use App\Entity\KnownIssue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KnownIssue|null find($id, $lockMode = null, $lockVersion = null)
 * @method KnownIssue|null findOneBy(array $criteria, array $orderBy = null)
 * @method KnownIssue[]    findAll()
 * @method KnownIssue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KnownIssueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KnownIssue::class);
    }

    // /**
    //  * @return KnownIssue[] Returns an array of KnownIssue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KnownIssue
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
