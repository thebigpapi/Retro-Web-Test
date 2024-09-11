<?php

namespace App\Repository;

use App\Entity\Chip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chip[]    findAll()
 * @method Chip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chip::class);
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
     * @return Chip[]
     */
    public function findByChip(array $criteria): array
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
        if (array_key_exists('processNode', $criteria)) {
            $whereArray[] = "chip.processNode = :processLike";
            $valuesArray["processLike"] = $criteria['processNode'];
        }
        if (array_key_exists('tdp', $criteria)) {
            $whereArray[] = "chip.tdp = :tdpLike";
            $valuesArray["tdpLike"] = $criteria['tdp'];
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
        if (array_key_exists('sockets', $criteria)) {
            foreach ($criteria['sockets'] as $key => $val) {
                $whereArraySocket[] = "(cs.id = :socketId$key)";
                $valuesArray["socketId$key"] = $val;
            }
            $whereArray[] = implode(" OR ", $whereArraySocket);
        }

        if (array_key_exists('families', $criteria)) {
            foreach ($criteria['families'] as $key => $val) {
                $whereArrayPlatform[] = "(chip.family = :familyId$key)";
                $valuesArray["familyId$key"] = $val;
            }
            $whereArray[] = implode(" OR ", $whereArrayPlatform);
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
                FROM App\Entity\Chip chip 
                LEFT JOIN chip.manufacturer man 
                LEFT JOIN chip.chipAliases alias 
                LEFT JOIN chip.pciDevs dev 
                LEFT JOIN chip.type typ 
                LEFT JOIN chip.sockets as cs 
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

    public function findByPciId(array $ids): array
    {
        $entityManager = $this->getEntityManager();

        // Building query
        if($ids == [])
            return [];

        $intVenIds = [];
        $intDevIds = [];
        foreach($ids[0] as $id){
            array_push($intVenIds, $this->hex2Int($id));
        }
        foreach($ids[1] as $id){
            array_push($intDevIds, $this->hex2Int($id));
        }
        if($intVenIds == [] || $intVenIds == [])
            return [];
        $query = $entityManager->createQuery(
            "SELECT chip
            FROM App\Entity\Chip chip JOIN chip.manufacturer man LEFT JOIN chip.pciDevs dev LEFT JOIN man.pciVendorIds ven
            WHERE dev.dev in (:devLike) AND ven.ven in (:venLike)
            ORDER BY man.name ASC, chip.name ASC"
        );

        $query->setParameter("venLike", $intVenIds)->setParameter("devLike", $intDevIds);
        return $query->getResult();
    }
    /**
     * @return Chip[]
     */
    public function findAllChipManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT chip
            FROM App\Entity\Chip chip, App\Entity\Manufacturer man 
            WHERE chip.manufacturer=man 
            ORDER BY man.name ASC, chip.name ASC'
        );

        return $query->getResult();
    }
    /**
     * @return Chip[]
     */
    public function findByPopularity()
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\Chip', 'ec');
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
     * @return Chip[]
     */
    public function findAllByCreditor(int $cid): array
    {
        $entityManager = $this->getEntityManager();
        $dql   = "SELECT DISTINCT ec
        FROM App:Chip ec
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
    /**
     * @return Chip[]
     */
    public function getManufCount(): array
    {
        $entityManager = $this->getEntityManager();
        $result = $entityManager->createQuery(
            'SELECT COALESCE(man.name, \'Unidentified\') as name, COUNT(c.id) as count
            FROM App\Entity\Chip c LEFT JOIN c.manufacturer man
            GROUP BY man
            ORDER BY count DESC'
        )->getResult();

        $finalArray = array();

        foreach ($result as $subArray) {
            $finalArray[$subArray['name']] = $subArray['count'];
        }

        return $finalArray;
    }

    /**
     * @return Chip[]
     */
    public function getSocketCount(): array
    {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('cnt', 'cnt');

        $result = $entityManager->createNativeQuery(
            "SELECT c.id, coalesce(c.name, c.type) AS name, s.cnt
            FROM cpu_socket c INNER JOIN (SELECT cpu_socket_id, count(cpu_socket_id) AS cnt FROM chip_cpu_socket cc GROUP BY cpu_socket_id) s ON c.id = s.cpu_socket_id
            ORDER BY cnt DESC",$rsm)->getResult();
        $finalArray = array();
        foreach ($result as $subArray) {
            $finalArray[$subArray['name']] = $subArray['cnt'];
        }
        return $finalArray;
    }

    /**
     * @return Chip[]
     */
    public function getTypeCount(): array
    {
        $entityManager = $this->getEntityManager();
        $result = $entityManager->createQuery(
            'SELECT t.name, COUNT(t.id) as count
            FROM App\Entity\Chip c LEFT JOIN c.type t
            GROUP BY t
            ORDER BY count DESC'
        )->getResult();

        $finalArray = array();

        foreach ($result as $subArray) {
            $finalArray[$subArray['name']] = $subArray['count'];
        }

        return $finalArray;
    }

    /**
     * @return Chip[] Returns the last 12 edited motherboards. Used in home page.
     */
    public function findLatest(int $maxCount = 12)
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.lastEdited', 'DESC')
            ->setMaxResults($maxCount)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Chip[] Returns the last 12 edited motherboards. Used in home page.
     */
    public function findByType(int $value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.type = :val')
            ->setParameter('val', $value)
            ->orderBy('c.partNumber', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllAlphabetic(string $letter): array
    {
        $entityManager = $this->getEntityManager();
        if (empty($letter)) {
            $query = $entityManager->createQuery(
                "SELECT 'Unknown' as manName, chip.name, chip.id, UPPER(chip.name) as chipNameSort, chip.lastEdited
                FROM App\Entity\Chip chip
                WHERE chip.manufacturer IS NULL
                ORDER BY chipNameSort ASC"
            );
        } else {
            $likematch = "$letter%";

            $query = $entityManager->createQuery(
                "SELECT man.name as manName, chip.name, chip.id, UPPER(man.name) as manNameSort, UPPER(chip.name) as chipNameSort, chip.lastEdited
                FROM App\Entity\Chip chip, App\Entity\Manufacturer man
                WHERE chip.manufacturer=man AND UPPER(man.name) like :likeMatch
                ORDER BY manNameSort ASC, chipNameSort ASC"
            )->setParameter('likeMatch', $likematch);
        }

        return $query->getResult();
    }
}
