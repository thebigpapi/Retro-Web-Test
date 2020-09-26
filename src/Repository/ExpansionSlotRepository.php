<?php

namespace App\Repository;

use App\Entity\ExpansionSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ExpansionSlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionSlot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionSlot[]    findAll()
 * @method ExpansionSlot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionSlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionSlot::class);
    }

    // /**
    //  * @return ExpansionSlot[] Returns an array of ExpansionSlot objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExpansionSlot
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
