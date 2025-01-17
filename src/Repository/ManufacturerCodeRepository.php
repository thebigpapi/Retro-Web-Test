<?php

namespace App\Repository;

use App\Entity\ManufacturerCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ManufacturerCode>
 *
 * @method ManufacturerCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManufacturerCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManufacturerCode[]    findAll()
 * @method ManufacturerCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManufacturerCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ManufacturerCode::class);
    }

    public function save(ManufacturerCode $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ManufacturerCode $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ManufacturerCode[] Returns an array of ManufacturerCode objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ManufacturerCode
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
