<?php

namespace App\Repository;

use App\Entity\ManufacturerBiosManufacturerCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ManufacturerBiosManufacturerCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManufacturerBiosManufacturerCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManufacturerBiosManufacturerCode[]    findAll()
 * @method ManufacturerBiosManufacturerCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManufacturerBiosManufacturerCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ManufacturerBiosManufacturerCode::class);
    }

    // /**
    //  * @return ManufacturerBiosManufacturerCode[] Returns an array of ManufacturerBiosManufacturerCode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ManufacturerBiosManufacturerCode
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
