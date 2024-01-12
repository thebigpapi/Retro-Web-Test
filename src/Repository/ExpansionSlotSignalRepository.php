<?php

namespace App\Repository;

use App\Entity\ExpansionSlotSignal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionSlotSignal>
 *
 * @method ExpansionSlotSignal|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionSlotSignal|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionSlotSignal[]    findAll()
 * @method ExpansionSlotSignal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionSlotSignalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionSlotSignal::class);
    }

//    /**
//     * @return ExpansionSlotSignal[] Returns an array of ExpansionSlotSignal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExpansionSlotSignal
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
