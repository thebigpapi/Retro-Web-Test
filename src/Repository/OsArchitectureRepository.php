<?php

namespace App\Repository;

use App\Entity\OsArchitecture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OsArchitecture>
 *
 * @method OsArchitecture|null find($id, $lockMode = null, $lockVersion = null)
 * @method OsArchitecture|null findOneBy(array $criteria, array $orderBy = null)
 * @method OsArchitecture[]    findAll()
 * @method OsArchitecture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OsArchitectureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OsArchitecture::class);
    }

//    /**
//     * @return OsArchitecture[] Returns an array of OsArchitecture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OsArchitecture
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
