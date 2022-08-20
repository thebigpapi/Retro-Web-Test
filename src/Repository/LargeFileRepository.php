<?php

namespace App\Repository;

use App\Entity\LargeFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LargeFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method LargeFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method LargeFile[]    findAll()
 * @method LargeFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LargeFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LargeFile::class);
    }

    // /**
    //  * @return LargeFile[] Returns an array of LargeFile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findAllAlphabetic(string $letter): array
    {
        $entityManager = $this->getEntityManager();
        $likematch = "$letter%";
        $query = $entityManager->createQuery(
                "SELECT drv
                FROM App\Entity\LargeFile drv 
                WHERE drv.name like :likeMatch
                ORDER BY drv.name ASC"
            )->setParameter('likeMatch', $likematch);

        return $query->getResult();
    }
    public function findByDriver(array $criteria): array
    {

        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $whereArray[] = "(LOWER(drv.name) LIKE :nameLike OR LOWER(drv.fileVersion) LIKE :nameLike)";
            $valuesArray["nameLike"] = "%" . strtolower($criteria['name']) . "%";
        }

        // Building where statement
        $whereString = implode(" AND ", $whereArray);

        // Building query
        $query = $entityManager->createQuery(
            "SELECT drv
            FROM App\Entity\LargeFile drv
            WHERE $whereString
            ORDER BY drv.name ASC"
        );

        // Setting values
        foreach ($valuesArray as $key => $value) {
            $query->setParameter($key, $value);
        }
        return $query->getResult();
    }
    public function getCount(): int
    {
        return $this->createQueryBuilder('l')
            ->select('count(l.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    /*
    public function findOneBySomeField($value): ?LargeFile
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
