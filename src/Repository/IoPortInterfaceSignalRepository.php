<?php

namespace App\Repository;

use App\Entity\IoPortInterfaceSignal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IoPortInterfaceSignal>
 *
 * @method IoPortInterfaceSignal|null find($id, $lockMode = null, $lockVersion = null)
 * @method IoPortInterfaceSignal|null findOneBy(array $criteria, array $orderBy = null)
 * @method IoPortInterfaceSignal[]    findAll()
 * @method IoPortInterfaceSignal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IoPortInterfaceSignalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IoPortInterfaceSignal::class);
    }

//    /**
//     * @return IoPortInterfaceSignal[] Returns an array of IoPortInterfaceSignal objects
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

//    public function findOneBySomeField($value): ?IoPortInterfaceSignal
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
