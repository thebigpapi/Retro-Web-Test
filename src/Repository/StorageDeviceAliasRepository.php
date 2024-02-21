<?php

namespace App\Repository;

use App\Entity\StorageDeviceAlias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StorageDeviceAlias>
 *
 * @method StorageDeviceAlias|null find($id, $lockMode = null, $lockVersion = null)
 * @method StorageDeviceAlias|null findOneBy(array $criteria, array $orderBy = null)
 * @method StorageDeviceAlias[]    findAll()
 * @method StorageDeviceAlias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StorageDeviceAliasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StorageDeviceAlias::class);
    }

    public function save(StorageDeviceAlias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StorageDeviceAlias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return StorageDeviceAlias[] Returns an array of StorageDeviceAlias objects
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

//    public function findOneBySomeField($value): ?StorageDeviceAlias
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
