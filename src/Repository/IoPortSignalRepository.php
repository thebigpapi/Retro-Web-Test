<?php

namespace App\Repository;

use App\Entity\IoPortSignal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IoPortSignal>
 *
 * @method IoPortSignal|null find($id, $lockMode = null, $lockVersion = null)
 * @method IoPortSignal|null findOneBy(array $criteria, array $orderBy = null)
 * @method IoPortSignal[]    findAll()
 * @method IoPortSignal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IoPortSignalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IoPortSignal::class);
    }

//    /**
//     * @return IoPortSignal[] Returns an array of IoPortSignal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?IoPortSignal
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
