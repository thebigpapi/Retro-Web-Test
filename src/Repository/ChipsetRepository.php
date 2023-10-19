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
        JOIN c.manufacturer m LEFT JOIN c.expansionChips cp
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
                $whereArray[] = "(LOWER(chip.name) LIKE :nameLike$key 
                    OR LOWER(chip.part_no) LIKE :nameLike$key 
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

        // Building where statement
        $whereString = implode(" AND ", $whereArray);

        // Building query
        if($whereArray == []){
            $query = $entityManager->createQuery(
                "SELECT chip
                FROM App\Entity\Chipset chip JOIN chip.manufacturer man JOIN chip.expansionChips part LEFT OUTER JOIN chip.chipsetAliases alias
                WHERE chip.id < 10000
                ORDER BY man.name ASC, chip.name ASC"
            );
        }
        else{
            $query = $entityManager->createQuery(
                "SELECT chip
                FROM App\Entity\Chipset chip JOIN chip.manufacturer man JOIN chip.expansionChips part LEFT OUTER JOIN chip.chipsetAliases alias
                WHERE $whereString
                ORDER BY man.name ASC, chip.name ASC"
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
            "SELECT chip
            FROM App\Entity\Chipset chip JOIN chip.manufacturer man JOIN chip.expansionChips part LEFT OUTER JOIN chip.chipsetAliases alias
            WHERE part.id IN $whereString
            ORDER BY man.name ASC, chip.name ASC"
        );
        return $query->getResult();
    }
    /**
     * @return Chipset[]
     */
    public function findAllAlphabetic(string $letter): array
    {
        $entityManager = $this->getEntityManager();
        $likematch = "$letter%";
        $query = $entityManager->createQuery(
            "SELECT chip, chipPart, chipPartMan, cal, UPPER(man.name) manNameSort, UPPER(chip.name) chipNameSort
            FROM App\Entity\Chipset chip
            LEFT JOIN chip.expansionChips chipPart
            LEFT JOIN chipPart.manufacturer chipPartMan
            LEFT JOIN chip.chipsetAliases cal,
            App\Entity\Manufacturer man 
            WHERE chip.manufacturer=man AND UPPER(man.name) like :likeMatch
            ORDER BY manNameSort ASC, chipNameSort ASC"
        )->setParameter('likeMatch', $likematch);

        $outputArray = [];
        foreach ($query->getResult() as $res) {
            $outputArray[] = $res[0];
        };
        return $outputArray;
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
     * @return Chipset[] Returns an array of sockets and count of board for each socket
     */
    public function getChipsetDocCount(): array
    {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('count', 'count');

        $result = $entityManager->createNativeQuery(
            "SELECT count(DISTINCT chipset_id) FROM chipset_expansion_chip WHERE expansion_chip_id IN
            (SELECT id FROM chip WHERE id NOT IN (SELECT chip_id FROM chip_documentation) AND dtype='expansionchip')",$rsm)->getResult();
        return $result;
    }
}
