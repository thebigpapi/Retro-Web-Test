<?php

namespace App\Repository;

use App\Entity\StorageDeviceMiscFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StorageDeviceMiscFile>
 *
 * @method StorageDeviceMiscFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method StorageDeviceMiscFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method StorageDeviceMiscFile[]    findAll()
 * @method StorageDeviceMiscFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StorageDeviceMiscFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StorageDeviceMiscFile::class);
    }

//    /**
//     * @return StorageDeviceMiscFile[] Returns an array of StorageDeviceMiscFile objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StorageDeviceMiscFile
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
