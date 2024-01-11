<?php

namespace App\Repository;

use App\Entity\ExpansionCardIoPort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionCardIoPort>
 *
 * @method ExpansionCardIoPort|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionCardIoPort|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionCardIoPort[]    findAll()
 * @method ExpansionCardIoPort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionCardIoPortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionCardIoPort::class);
    }

//    /**
//     * @return ExpansionCardIoPort[] Returns an array of ExpansionCardIoPort objects
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

//    public function findOneBySomeField($value): ?ExpansionCardIoPort
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
