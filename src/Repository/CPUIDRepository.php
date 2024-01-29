<?php

namespace App\Repository;

use App\Entity\CPUID;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CPUID>
 *
 * @method CPUID|null find($id, $lockMode = null, $lockVersion = null)
 * @method CPUID|null findOneBy(array $criteria, array $orderBy = null)
 * @method CPUID[]    findAll()
 * @method CPUID[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CPUIDRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CPUID::class);
    }

//    /**
//     * @return CPUID[] Returns an array of CPUID objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CPUID
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
