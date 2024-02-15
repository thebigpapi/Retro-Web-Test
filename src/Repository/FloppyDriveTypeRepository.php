<?php

namespace App\Repository;

use App\Entity\FloppyDriveType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FloppyDriveType>
 *
 * @method FloppyDriveType|null find($id, $lockMode = null, $lockVersion = null)
 * @method FloppyDriveType|null findOneBy(array $criteria, array $orderBy = null)
 * @method FloppyDriveType[]    findAll()
 * @method FloppyDriveType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FloppyDriveTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FloppyDriveType::class);
    }

//    /**
//     * @return FloppyDriveType[] Returns an array of FloppyDriveType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FloppyDriveType
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
