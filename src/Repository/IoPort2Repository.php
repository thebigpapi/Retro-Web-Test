<?php

namespace App\Repository;

use App\Entity\IoPort2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IoPort2>
 *
 * @method IoPort2|null find($id, $lockMode = null, $lockVersion = null)
 * @method IoPort2|null findOneBy(array $criteria, array $orderBy = null)
 * @method IoPort2[]    findAll()
 * @method IoPort2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IoPort2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IoPort2::class);
    }

//    /**
//     * @return IoPort2[] Returns an array of IoPort2 objects
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

//    public function findOneBySomeField($value): ?IoPort2
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
