<?php

namespace App\Repository;

use App\Entity\ExpansionChip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExpansionChip|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionChip|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionChip[]    findAll()
 * @method ExpansionChip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ExpansionChip[]    findAllExpansionChipManufacturer()
 * @method ExpansionChip[]    findByPopularity()
 */
class ExpansionChipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionChip::class);
    }
    public function hex2Int($PCIDEVID)
    {
        //check that characters are in hexadecimal
        if (!preg_match("/^[\da-fA-F]{4}$/", $PCIDEVID)) {
            return -1;
        }

        //convert to integer
        return hexdec($PCIDEVID);
    }
    /**
     * @return ExpansionChip[]
     */
    public function findByExpansionChip(array $criteria): array
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "(LOWER(chip.name) LIKE :nameLike$key 
                    OR LOWER(chip.partNumber) LIKE :nameLike$key 
                    OR LOWER(alias.name) LIKE :nameLike$key 
                    OR LOWER(alias.partNumber) LIKE :nameLike$key)";
                $valuesArray["nameLike$key"] = "%" . strtolower($val) . "%";
            }
        }
        if (array_key_exists('deviceId', $criteria)) {
            $devId = $this->hex2Int($criteria['deviceId']);
            if($devId >= 0){
                $whereArray[] = "dev.dev = :devLike";
                $valuesArray["devLike"] = $devId;
            }
        }
        if (array_key_exists('manufacturer', $criteria)) {
            $whereArray[] = "(man.id = :manufacturerId)";
            $valuesArray["manufacturerId"] = (int)$criteria['manufacturer'];
        }
        if (array_key_exists('type', $criteria)) {
            $whereArray[] = "(typ.id = :typeId)";
            $valuesArray["typeId"] = (int)$criteria['type'];
        }

        // Building where statement
        $whereString = implode(" AND ", $whereArray);

        // Building query
        if($whereArray == []){
            return [];
        }
        else{
            $query = $entityManager->createQuery(
                "SELECT chip
                FROM App\Entity\ExpansionChip chip JOIN chip.manufacturer man LEFT OUTER JOIN chip.chipAliases alias LEFT JOIN chip.pciDevs dev LEFT JOIN chip.type typ
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
     * @return ExpansionChip[]
     */
    public function findAllExpansionChipManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT chip
            FROM App\Entity\ExpansionChip chip, App\Entity\Manufacturer man 
            WHERE chip.manufacturer=man 
            ORDER BY man.name ASC, chip.name ASC'
        );

        return $query->getResult();
    }
    /**
     * @return ExpansionChip[]
     */
    public function findByPopularity()
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\ExpansionChip', 'ec');
        $rsm->addJoinedEntityResult('App\Entity\Manufacturer', 'man', 'ec', 'manufacturer');
        $rsm->addFieldResult('ec', 'id', 'id');
        $rsm->addFieldResult('ec', 'name', 'name');
        $rsm->addFieldResult('ec', 'part_number', 'partNumber');
        $rsm->addFieldResult('man', 'man_id', 'id');
        $rsm->addFieldResult('man', 'man_name', 'name');

        $query = $entityManager->createNativeQuery(
            "SELECT ec.id, count(moboec.expansion_chip_id) as popularity, man.id as man_id, man.name as man_name, ch.name, ch.part_number
            FROM expansion_chip ec JOIN chip ch ON ch.id=ec.id JOIN manufacturer man ON ch.manufacturer_id=man.id LEFT JOIN motherboard_expansion_chip moboec ON ec.id=moboec.expansion_chip_id 
            GROUP BY ec.id, man_id, man_name, ch.name, ch.part_number
            ORDER BY popularity DESC;",
            $rsm
        );
        return $query->getResult();
    }
    /**
     * @return ExpansionChip[]
     */
    public function findAllByCreditor(int $cid): array
    {
        $entityManager = $this->getEntityManager();
        $dql   = "SELECT DISTINCT ec
        FROM App:ExpansionChip ec
        JOIN ec.images mi LEFT JOIN mi.creditor c
        WHERE c.id = :cid
        ORDER BY ec.name ASC";
        $query = $entityManager->createQuery($dql)->setParameter(":cid", $cid);
        return $query->getResult();
    }
    public function getCount(): int
    {
        return $this->createQueryBuilder('ec')
            ->select('count(ec.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
