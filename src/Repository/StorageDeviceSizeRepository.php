<?php

namespace App\Repository;

use App\Entity\StorageDeviceSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StorageDeviceSize>
 *
 * @method StorageDeviceSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method StorageDeviceSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method StorageDeviceSize[]    findAll()
 * @method StorageDeviceSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StorageDeviceSizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StorageDeviceSize::class);
    }

    public function save(StorageDeviceSize $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StorageDeviceSize $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return StorageDeviceSize[] Returns an array of StorageDeviceSize objects
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

//    public function findOneBySomeField($value): ?StorageDeviceSize
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
