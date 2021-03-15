<?php

namespace App\Repository;

use App\Entity\InstructionSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InstructionSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstructionSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstructionSet[]    findAll()
 * @method InstructionSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstructionSetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstructionSet::class);
    }

    // /**
    //  * @return InstructionSet[] Returns an array of InstructionSet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InstructionSet
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
