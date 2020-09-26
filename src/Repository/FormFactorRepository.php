<?php

namespace App\Repository;

use App\Entity\FormFactor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormFactor|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormFactor|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormFactor[]    findAll()
 * @method FormFactor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormFactorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormFactor::class);
    }

    // /**
    //  * @return FormFactor[] Returns an array of FormFactor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormFactor
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
