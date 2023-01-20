<?php

namespace App\Repository;

use App\Entity\PciDeviceId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PciDeviceId>
 *
 * @method PciDeviceId|null find($id, $lockMode = null, $lockVersion = null)
 * @method PciDeviceId|null findOneBy(array $criteria, array $orderBy = null)
 * @method PciDeviceId[]    findAll()
 * @method PciDeviceId[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PciDeviceIdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PciDeviceId::class);
    }

    public function add(PciDeviceId $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PciDeviceId $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PciDeviceId[] Returns an array of PciDeviceId objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PciDeviceId
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
