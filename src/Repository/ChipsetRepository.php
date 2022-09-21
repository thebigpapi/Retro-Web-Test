<?php

namespace App\Repository;

use App\Entity\Chipset;
use App\Entity\Manufacturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chipset|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chipset|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chipset[]    findAll()
 * @method Chipset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChipsetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chipset::class);
    }

    /**
     * @return Chipset[]
     */
    public function findAllChipsetManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $dql   = "SELECT c, cp 
        FROM App:Chipset c 
        JOIN c.manufacturer m LEFT JOIN c.chipsetParts cp
        ORDER BY m.name ASC, c.name ASC";
        $query = $entityManager->createQuery($dql);

        return $query->getResult();
    }
    /**
     * @return Chipset[]
     */
    public function findByChipset(array $criteria): array
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val){
                $whereArray[] = "(LOWER(chip.name) LIKE :nameLike$key OR LOWER(chip.part_no) LIKE :nameLike$key)";
                $valuesArray["nameLike$key"] = "%" . strtolower($val) . "%";
            }
        }
        if (array_key_exists('manufacturer', $criteria)) {
            $whereArray[] = "(man.id = :manufacturerId)";
            $valuesArray["manufacturerId"] = (int)$criteria['manufacturer'];
        }

        // Building where statement
        $whereString = implode(" AND ", $whereArray);

        // Building query
        $query = $entityManager->createQuery(
            "SELECT chip
            FROM App\Entity\Chipset chip JOIN chip.manufacturer man
            WHERE $whereString
            ORDER BY man.name ASC, chip.release_date ASC, chip.name ASC"
        );

        // Setting values
        foreach ($valuesArray as $key => $value) {
            $query->setParameter($key, $value);
        }

        return $query->getResult();
    }
    /**
     * @return Chipset[]
     */
    public function findAllAlphabetic(string $letter): array
    {
        $entityManager = $this->getEntityManager();
        if (empty($letter)) {
            $query = $entityManager->createQuery(
                "SELECT chip
                FROM App\Entity\Chipset chip, App\Entity\Manufacturer man 
                WHERE chip.manufacturer=man IS NULL
                ORDER BY man.name ASC, chip.name ASC"
            );
        } else {
            $likematch = "$letter%";
            $query = $entityManager->createQuery(
                "SELECT chip
                FROM App\Entity\Chipset chip, App\Entity\Manufacturer man 
                WHERE chip.manufacturer=man AND COALESCE(man.shortName, man.name) like :likeMatch
                ORDER BY man.name ASC, chip.name ASC"
            )->setParameter('likeMatch', $likematch);
        }

        return $query->getResult();
    }

    /**
     * @return Chipset[]
     */
    public function findByManufacturer(Manufacturer $man)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.manufacturer = :man')
            ->setParameter('man', $man)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getCount(): int
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
