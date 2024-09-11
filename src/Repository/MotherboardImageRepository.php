<?php

namespace App\Repository;

use App\Entity\MotherboardImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MotherboardImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardImage[]    findAll()
 * @method MotherboardImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardImage::class);
    }

    // /**
    //  * @return MotherboardImage[] Returns an array of MotherboardImage objects
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

    public function findAllImages(): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT entity.file_name
            FROM App\Entity\MotherboardImage entity
            WHERE entity.file_name NOT LIKE '%.svg%'"
        );
        $result = array_column($query->getResult(), "file_name");
        foreach($result as &$r)
            $r = "/motherboard/image/" . $r;

        return $result;
    }
}
