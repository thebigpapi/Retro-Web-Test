<?php

namespace App\Repository;

use App\Entity\IoPortType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IoPortType>
 *
 * @method IoPortType|null find($id, $lockMode = null, $lockVersion = null)
 * @method IoPortType|null findOneBy(array $criteria, array $orderBy = null)
 * @method IoPortType[]    findAll()
 * @method IoPortType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IoPortTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IoPortType::class);
    }

//    /**
//     * @return IoPortType[] Returns an array of IoPortType objects
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

//    public function findOneBySomeField($value): ?IoPortType
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
