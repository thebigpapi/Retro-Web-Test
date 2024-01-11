<?php

namespace App\Repository;

use App\Entity\ExpansionSlot2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionSlot2>
 *
 * @method ExpansionSlot2|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionSlot2|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionSlot2[]    findAll()
 * @method ExpansionSlot2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionSlot2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionSlot2::class);
    }

//    /**
//     * @return ExpansionSlot2[] Returns an array of ExpansionSlot2 objects
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

//    public function findOneBySomeField($value): ?ExpansionSlot2
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
