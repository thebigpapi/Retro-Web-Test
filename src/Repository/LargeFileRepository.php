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

    /**
      * @return LargeFile[] Returns an array of LargeFile objects
      */
    public function findAllOptimized(): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT lf, lang, mtf, ofgs
            FROM App\Entity\LargeFile lf
            JOIN lf.osFlags as ofgs
            ORDER BY lf.name ASC"
        );

        return $query->getResult();
    }

    public function findAllAlphabetic(string $letter): array
    {
        $entityManager = $this->getEntityManager();
        $likematch = "$letter%";
        $query = $entityManager->createQuery(
            "SELECT drv.id, UPPER(drv.name) drvNameSort, drv.lastEdited
                FROM App\Entity\LargeFile drv
                WHERE UPPER(drv.name) like :likeMatch
                ORDER BY drvNameSort ASC"
        )->setParameter('likeMatch', $likematch);

        return $query->getResult();
    }

    public function findByDriver(array $criterias): array
    {

        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criterias)) {
            $multicrit = explode(" ", $criterias['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "(LOWER(drv.name) LIKE :nameLike$key OR LOWER(drv.fileVersion) LIKE :nameLike$key OR LOWER(drv.file_name) LIKE :nameLike$key)";
                $valuesArray["nameLike$key"] = "%" . strtolower($val) . "%";
            }
        }
        if (array_key_exists('file_name', $criterias)) {
            $whereArray[] = "(LOWER(drv.file_name) LIKE LOWER(:fileName))";
            $valuesArray["fileName"] = "%" . $criterias['file_name'] . "%";
        }
        if (array_key_exists('version', $criterias)) {
            $whereArray[] = "(drv.fileVersion LIKE :version)";
            $valuesArray["version"] = "%" . $criterias['version'] . "%";
        }
        if (array_key_exists('osFlags', $criterias)) {
            foreach ($criterias['osFlags'] as $key => $value) {
                $whereArray[] = "(drv.id in (select drv$key.id from App\Entity\LargeFile drv$key JOIN drv$key.osFlags os$key where os$key.id=:idOs$key))";
                $valuesArray["idOs$key"] = $value;
        }
        }

        // Building where statement
        $whereString = implode(" AND ", $whereArray);

        // Building query
        if($whereArray == []){
            return [];
        }
        else{
            $query = $entityManager->createQuery(
                "SELECT drv
                FROM App\Entity\LargeFile drv
                WHERE $whereString
                ORDER BY drv.name ASC, drv.file_name ASC"
            )->setMaxResults(1000);
        }

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
    /**
      * @return LargeFile[] Returns an array of LargeFile objects
      */
    public function findLatest(int $maxCount = 24)
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.lastEdited', 'DESC')
            ->setMaxResults($maxCount)
            ->getQuery()
            ->getResult();
    }
}
