<?php

namespace App\Repository;

use App\Entity\StorageDeviceInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StorageDeviceInterface>
 *
 * @method StorageDeviceInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method StorageDeviceInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method StorageDeviceInterface[]    findAll()
 * @method StorageDeviceInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StorageDeviceInterfaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StorageDeviceInterface::class);
    }

    public function save(StorageDeviceInterface $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StorageDeviceInterface $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return StorageDeviceInterface[] Returns an array of StorageDeviceInterface objects
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

//    public function findOneBySomeField($value): ?StorageDeviceInterface
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
