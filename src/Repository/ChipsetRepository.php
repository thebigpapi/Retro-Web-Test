<?php

namespace App\Repository;

use App\Entity\Chipset;
use App\Entity\Manufacturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Generator;

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
        JOIN c.manufacturer m LEFT JOIN c.chips cp
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
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "(LOWER(chipset.name) LIKE :nameLike$key 
                    OR LOWER(chipset.part_no) LIKE :nameLike$key 
                    OR LOWER(part.name) LIKE :nameLike$key
                    OR LOWER(part.partNumber) LIKE :nameLike$key
                    OR LOWER(alias.name) LIKE :nameLike$key 
                    OR LOWER(alias.partNumber) LIKE :nameLike$key)";
                $valuesArray["nameLike$key"] = "%" . strtolower($val) . "%";
            }
        }
        if (array_key_exists('manufacturer', $criteria)) {
            $whereArray[] = "(man.id = :manufacturerId)";
            $valuesArray["manufacturerId"] = (int)$criteria['manufacturer'];
        }
        if (array_key_exists('chips', $criteria)) {
            foreach ($criteria['chips'] as $key => $value) {
                $whereArray[] = "(chipset.id in (select chipset$key.id from App\Entity\Chipset chipset$key JOIN chipset$key.chips ec$key where ec$key.id=:idChip$key))";
                $valuesArray["idChip$key"] = $value;
        }
        }

        // Building where statement
        $whereString = implode(" AND ", $whereArray);

        // Building query
        if ($whereArray == []) {
            return [];
        } else {
            $query = $entityManager->createQuery(
                "SELECT chipset
                FROM App\Entity\Chipset chipset JOIN chipset.manufacturer man JOIN chipset.chips part LEFT OUTER JOIN chipset.chipsetAliases alias
                WHERE $whereString
                ORDER BY man.name ASC, chipset.name ASC"
            );
        }
        // Setting values
        foreach ($valuesArray as $key => $value) {
            $query->setParameter($key, $value);
        }
        return $query->getResult();
    }
    /**
     * @return Chipset[]
     */
    public function findByChips(array $criteria): array
    {
        $entityManager = $this->getEntityManager();
        $whereString = "(";
        foreach ($criteria as $key => $val) {
            $whereString .= "$val";
            if ($key !== array_key_last($criteria)) {
                $whereString .= ",";
            }
        }
        $whereString .= ")";
        $query = $entityManager->createQuery(
            "SELECT chipset
            FROM App\Entity\Chipset chipset JOIN chipset.manufacturer man JOIN chipset.chips part LEFT OUTER JOIN chipset.chipsetAliases alias
            WHERE part.id IN $whereString
            ORDER BY man.name ASC, chipset.name ASC"
        );
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
                "SELECT 'Unknown' as manName, chipset.id, UPPER(chipset.name) chipNameSort, chipset.lastEdited
                FROM App\Entity\Chipset chipset
                WHERE chipset.manufacturer IS NULL
                ORDER BY chipNameSort ASC");
        } else {
            $likematch = "$letter%";
            $query = $entityManager->createQuery(
                "SELECT chipset.id, UPPER(man.name) manNameSort, UPPER(chipset.name) chipNameSort, chipset.lastEdited
                FROM App\Entity\Chipset chipset, App\Entity\Manufacturer man
                WHERE chipset.manufacturer=man AND UPPER(man.name) like :likeMatch
                ORDER BY manNameSort ASC, chipNameSort ASC"
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
            ->getResult();
    }

    public function getCount(): int
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    /**
     * @return Chipset[]
     */
    public function getManufCount(): array
    {
        $entityManager = $this->getEntityManager();
        $result = $entityManager->createQuery(
            'SELECT COALESCE(man.name, \'Unidentified\') as name, COUNT(c.id) as count
            FROM App\Entity\Chipset c LEFT JOIN c.manufacturer man
            GROUP BY man
            ORDER BY count DESC'
        )->getResult();

        $finalArray = array();

        foreach ($result as $subArray) {
            $finalArray[$subArray['name']] = $subArray['count'];
        }

        return $finalArray;
    }
    public function getChipsetDocCount(): array
    {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('count', 'count');

        $result = $entityManager->createNativeQuery(
            "SELECT count(DISTINCT chipset_id) FROM chipset_chip WHERE chip_id IN
            (SELECT id FROM chip WHERE id NOT IN (SELECT chip_id FROM chip_documentation))",
            $rsm
        )->getResult();
        return $result;
    }
    /**
     * @return Chipset[]
     */
    public function findLatest(int $maxCount = 12)
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.lastEdited', 'DESC')
            ->setMaxResults($maxCount)
            ->getQuery()
            ->getResult();
    }
}
