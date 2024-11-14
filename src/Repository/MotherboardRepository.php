<?php

namespace App\Repository;

use App\Entity\Manufacturer;
use App\Entity\Motherboard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method Motherboard|null find($id, $lockMode = null, $lockVersion = null)
 * @method Motherboard|null findSlug($slug)
 * @method Motherboard|null findOneBy(array $criteria, array $orderBy = null)
 * @method Motherboard[]    findAll()
 * @method Motherboard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Motherboard[]    findByWithJoin(array $criteria)
 * @method Motherboard[]    findLatest(int $maxCount = 12)
 */
class MotherboardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Motherboard::class);
    }

    // big mobo search bongaloo begins here

    private function separateArraysFromValues(array $source, array &$arrays, array &$values): void
    {
        foreach ($source as $key => $val) {
            if (is_array($val)) {
                $arrays[$key] = json_decode(json_encode($val), true);
            } else {
                $values[$key] = $val;
            }
        }
    }

    private function expansionSlotsToSQL(array $expansionSlots, array $from): array
    {
        foreach ($expansionSlots as $key => $slot) {
            $fromLength = count($from);
            if (isset($slot['count'])) {
                $from[] = (count($from) == 0 ? " (" : " INTERSECT") . " SELECT mex.motherboard_id as id
                    FROM motherboard_expansion_slot mex
                    WHERE mex.expansion_slot_id=:idSlot" . $key . " AND (
                        (mex.count=:slotCount" . $key . " AND :signSlot" . $key . "= '=') OR
                        (mex.count>:slotCount" . $key . " AND :signSlot" . $key . "= '>') OR
                        (mex.count<:slotCount" . $key . " AND :signSlot" . $key . "= '<') OR
                        (mex.count<=:slotCount" . $key . " AND :signSlot" . $key . "= '<=') OR
                        (mex.count>=:slotCount" . $key . " AND :signSlot" . $key . "= '>='))";
            } else {
                $from[] = (count($from) == 0 ? " (" : " INTERSECT") . " SELECT mb.id as id FROM motherboard mb
                LEFT JOIN (SELECT *
                FROM motherboard_expansion_slot sub_mex
                WHERE sub_mex.expansion_slot_id=:idSlot$key ) as mex ON mex.motherboard_id=mb.id 
                WHERE expansion_slot_id is NULL";
            }
            
        }
        return $from;
    }

    private function ioPortsToSQL(array $ioPorts, array $from): array
    {
        foreach ($ioPorts as $key => $port) {
            if (isset($port['count'])) {
                $from[] = (count($from) == 0 ? " (" : " INTERSECT") . " SELECT mip.motherboard_id as id
                    FROM motherboard_io_port mip 
                    WHERE mip.io_port_id = :idPort" . $key . " AND (
                    (mip.count=:portCount" . $key . " AND :signPort" . $key . "= '=') OR
                    (mip.count>:portCount" . $key . " AND :signPort" . $key . "= '>') OR
                    (mip.count<:portCount" . $key . " AND :signPort" . $key . "= '<') OR
                    (mip.count<=:portCount" . $key . " AND :signPort" . $key . "= '<=') OR
                    (mip.count>=:portCount" . $key . " AND :signPort" . $key . "= '>='))";
            } else {
                $from[] = (count($from) == 0 ? " (" : " INTERSECT") . " SELECT mb.id as id FROM motherboard mb
                LEFT JOIN (SELECT *
                FROM motherboard_io_port sub_mip
                WHERE sub_mip.io_port_id=:idPort$key ) as mip ON mip.motherboard_id=mb.id 
                WHERE io_port_id is NULL";
            }

        }

        return $from;
    }
    private function chipsToSQL(array $chips, array $from): array
    {
        foreach ($chips as $key => $chip) {
            $from[] = (count($from) == 0 ? " (" : " INTERSECT") . " SELECT mc.motherboard_id as id
                    FROM motherboard_chip mc
                    WHERE mc.chip_id=:idChip" . $key;
        }
        return $from;
    }
    private function dramTypesToSQL(array $dramTypes, array $from): array
    {
        foreach ($dramTypes as $key => $type) {
            $from[] = (count($from) == 0 ? " (" : " INTERSECT") . " SELECT mdt.motherboard_id as id
                FROM motherboard_dram_type mdt
                WHERE mdt.dram_type_id=:idType" . $key;
        }
        return $from;
    }

    private function valueToWhere(string $key, ?string $value): string //Warning ! Different behavior
    {
        return $key . "_id" . (is_null($value) ? " is NULL" : "=:$key");
    }

    private function valuesToWhere(array $values, array $where): array
    {
        foreach ($values as $key => $val) {
            $where[] = "mot." . $this->valueToWhere($key, $val);
        }
        return $where;
    }

    private function socketToSQL($socket1, $socket2, array $where): array
    {
        // Two sockets
        if ($socket1 && $socket2 && $socket1 != $socket2) {
            $where[] = "mot.id IN (SELECT socket1.motherboard_id
            FROM motherboard_cpu_socket as socket1
            JOIN motherboard_cpu_socket as socket2 on socket1.motherboard_id = socket2.motherboard_id
            WHERE socket1.cpu_socket_id=:socket1 AND socket2.cpu_socket_id=:socket2)";
        } else if ($socket1 && $socket2 && $socket1 == $socket2) {
            $where[] = "mot.id IN (SELECT id FROM motherboard WHERE max_cpu=2 AND id IN
            (SELECT motherboard_id FROM motherboard_cpu_socket WHERE cpu_socket_id=:socket))";
        } else { // One socket
            $where[] = "mot.id IN (SELECT motherboard_id FROM motherboard_cpu_socket WHERE cpu_socket_id=:socket)";
        }
        return $where;
    }

    private function platformToSQL($platform1, $platform2, array $where): array
    {
        // Two platforms
        if ($platform1 && $platform2 && $platform1 != $platform2) {
            $where[] = "mot.id IN (SELECT platform1.motherboard_id
            FROM motherboard_processor_platform_type as platform1
            JOIN motherboard_processor_platform_type as platform2 ON
            platform1.motherboard_id = platform2.motherboard_id 
            LEFT JOIN processor_platform_type_processor_platform_type AS comp1 ON 
            comp1.processor_platform_type_source=platform1.processor_platform_type_id
            LEFT JOIN processor_platform_type_processor_platform_type AS comp2 ON 
            comp2.processor_platform_type_source=platform2.processor_platform_type_id
            WHERE (platform1.processor_platform_type_id=:platform1 OR comp1.processor_platform_type_target=:platform1) AND (platform2.processor_platform_type_id=:platform2 OR comp2.processor_platform_type_target=:platform2))";
        } else { // One platform
            $where[] = "mot.id IN (SELECT motherboard_id FROM motherboard_processor_platform_type pl 
            LEFT JOIN processor_platform_type_processor_platform_type AS comp ON comp.processor_platform_type_source=pl.processor_platform_type_id 
            WHERE pl.processor_platform_type_id=:platform OR comp.processor_platform_type_target=:platform)";
        }
        return $where;
    }

    private function initResultSetMapping(): ResultSetMapping
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('App\Entity\Motherboard', 'mot');
        $rsm->addFieldResult('mot', 'id', 'id');
        $rsm->addFieldResult('mot', 'name', 'name');

        $rsm->addJoinedEntityResult('App\Entity\Manufacturer', 'man1', 'mot', 'manufacturer');
        $rsm->addFieldResult('man1', 'man1_id', 'id');
        $rsm->addFieldResult('man1', 'man1_name', 'name');

        $rsm->addJoinedEntityResult('App\Entity\Chipset', 'chp', 'mot', 'chipset');
        $rsm->addFieldResult('chp', 'chp_id', 'id');

        return $rsm;
    }

    private function prepareQuery(array $values, array $arrays): string
    {
        // Gathering name, manufacturer, sockets and platforms which are handled differently compared to other values
        if (array_key_exists('name', $values)) {
            $name = $values['name'];
            unset($values['name']);
        }
        if (array_key_exists('manufacturer', $values)) {
            $manufacturer = $values['manufacturer'];
            unset($values['manufacturer']);
        }
        if (array_key_exists('chipsetManufacturer', $values)) {
            $chipsetManufacturer = $values['chipsetManufacturer'];
            unset($values['chipsetManufacturer']);
        }
        if (array_key_exists('cpu_socket1', $values)) {
            $socket1 = $values['cpu_socket1'];
            unset($values['cpu_socket1']);
        }
        if (array_key_exists('cpu_socket2', $values)) {
            $socket2 = $values['cpu_socket2'];
            unset($values['cpu_socket2']);
        }
        if (array_key_exists('processor_platform_type1', $values)) {
            $platform1 = $values['processor_platform_type1'];
            unset($values['processor_platform_type1']);
        }
        if (array_key_exists('processor_platform_type2', $values)) {
            $platform2 = $values['processor_platform_type2'];
            unset($values['processor_platform_type2']);
        }

        // Creating interesct statements
        $from = array();


            if (array_key_exists("expansionSlots", $arrays)) {
                $from = $this->expansionSlotsToSQL($arrays['expansionSlots'], $from);
            }
            if (array_key_exists("ioPorts", $arrays)) {
                $from = $this->ioPortsToSQL($arrays['ioPorts'], $from);
            }
            if (array_key_exists("chips", $arrays)) {
                $from = $this->chipsToSQL($arrays['chips'], $from);
            }
            if (array_key_exists("dramTypes", $arrays)) {
                $from = $this->dramTypesToSQL($arrays['dramTypes'], $from);
            }


        // Creating where statements
        $where = $this->valuesToWhere($values, array());

        // Searching name and manufacturer into actual motherboard name and alias
        if (isset($name)) {
            if (array_key_exists('manufacturer', get_defined_vars())) {
                if (is_null($manufacturer)) {
                    $where[] = "((mot.name ILIKE :name AND mot.manufacturer_id IS NULL) OR mot.id IN
                    (SELECT motherboard_id FROM motherboard_alias AS ma
                    WHERE ma.name ILIKE :name AND ma.manufacturer_id IS NULL)) ";
                } else {
                    $where[] = "((mot.name ILIKE :name AND mot.manufacturer_id = :manufacturer) OR mot.id IN
                    (SELECT motherboard_id FROM motherboard_alias AS ma
                    WHERE ma.name ILIKE :name AND ma.manufacturer_id = :manufacturer)) ";
                }
            } else {
                $where[] = "((mot.name ILIKE :name) OR mot.id IN
                (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.name ILIKE :name)) ";
            }
        } elseif (array_key_exists('manufacturer', get_defined_vars())) {
            if (is_null($manufacturer)) {
                $where[] = "( mot.manufacturer_id IS NULL OR mot.id IN
                (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id IS NULL)) ";
            } else {
                $where[] = "( mot.manufacturer_id = :manufacturer OR mot.id IN
                (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id = :manufacturer)) ";
            }
        }

        if (array_key_exists('socket1', get_defined_vars()) && array_key_exists('socket2', get_defined_vars())) {
            $where = $this->socketToSQL($socket1, $socket2, $where);
        } elseif (array_key_exists('socket1', get_defined_vars())) {
            $where = $this->socketToSQL($socket1, null, $where);
        } elseif (array_key_exists('socket2', get_defined_vars())) {
            $where = $this->socketToSQL($socket2, null, $where);
        }

        if (array_key_exists('platform1', get_defined_vars()) && array_key_exists('platform2', get_defined_vars())) {
            $where = $this->platformToSQL($platform1, $platform2, $where);
        } elseif (array_key_exists('platform1', get_defined_vars())) {
            $where = $this->platformToSQL($platform1, null, $where);
        } elseif (array_key_exists('platform2', get_defined_vars())) {
            $where = $this->platformToSQL($platform2, null, $where);
        }

        // Creating where statement for boards without a chipset
        $whereNoChipset = $where;
        $whereNoChipset[] = "mot.chipset_id is NULL ";

        // Adding one last where statement for queries looking for the chipset manufacturer
        if (array_key_exists('chipsetManufacturer', get_defined_vars())) {
            $where[] = "chp.manufacturer_id=:chipsetManufacturer ";
        }

        // Turning from and where arrays to SQL statements
        $fromSql = !empty($from) ? "JOIN " . implode(" ", $from) . ") as io_slot_chip ON mot.id=io_slot_chip.id" : "";
        $whereSQL = (!empty($where)) ? " WHERE " .implode(" AND ", $where) : "";
        //dd($from);
        // Building SQL query
        $sql = "
            SELECT mot.*, man1.id as man1_id, man1.name as man1_name FROM motherboard mot
            LEFT JOIN manufacturer man1 ON mot.manufacturer_id = man1.id
            LEFT JOIN chipset chp ON mot.chipset_id = chp.id
            LEFT JOIN manufacturer man2 ON chp.manufacturer_id = man2.id
            $fromSql
            $whereSQL ORDER BY man1_name ASC, mot.name ASC LIMIT 10000";
        return $sql;
    }

    private function setQueryParameters(NativeQuery &$query, array $values, array $arrays): void
    {
        if (array_key_exists("expansionSlots", $arrays)) {
            foreach ($arrays['expansionSlots'] as $key => $val) {
                $query->setParameter("idSlot" . $key, $val['id']);
                $query->setParameter("signSlot" . $key, $val['sign']);
                if (array_key_exists("count", $val)) {
                    $query->setParameter("slotCount" . $key, $val['count']);
                }
            }
        }

        if (array_key_exists("ioPorts", $arrays)) {
            foreach ($arrays['ioPorts'] as $key => $val) {
                $query->setParameter("idPort" . $key, $val['id']);
                $query->setParameter("signPort" . $key, $val['sign']);
                if (array_key_exists("count", $val)) {
                    $query->setParameter("portCount" . $key, $val['count']);
                }
            }
        }

        if (array_key_exists("chips", $arrays)) {
            foreach ($arrays['chips'] as $key => $val) {
                $query->setParameter("idChip" . $key, $val);
            }
        }
        if (array_key_exists("dramTypes", $arrays)) {
            foreach ($arrays['dramTypes'] as $key => $val) {
                $query->setParameter("idType" . $key, $val);
            }
        }

        if (array_key_exists('cpu_socket1', $values) && array_key_exists('cpu_socket2', $values)) {
            if($values['cpu_socket1'] != $values['cpu_socket2']){
                $query->setParameter('socket1', $values['cpu_socket1']);
                $query->setParameter('socket2', $values['cpu_socket2']);
            }
            else{
                $query->setParameter('socket', $values['cpu_socket1']);
            }
        }
        else {
            if (array_key_exists('cpu_socket1', $values) && !array_key_exists('cpu_socket2', $values)) {
                $query->setParameter('socket', $values['cpu_socket1']);
            }
            elseif (array_key_exists('cpu_socket2', $values) && !array_key_exists('cpu_socket1', $values)) {
                $query->setParameter('socket', $values['cpu_socket2']);
            }
        }

        if (array_key_exists('processor_platform_type1', $values) && array_key_exists('processor_platform_type2', $values)){
            if($values['processor_platform_type1'] != $values['processor_platform_type2']){
                $query->setParameter('platform1', $values['processor_platform_type1']);
                $query->setParameter('platform2', $values['processor_platform_type2']);
            }
            else{
                $query->setParameter('platform', $values['processor_platform_type1']);
            }
        }
        else {
            if (array_key_exists('processor_platform_type1', $values) && !array_key_exists('processor_platform_type2', $values)) {
                $query->setParameter('platform', $values['processor_platform_type1']);
            }
            elseif (!array_key_exists('processor_platform_type1', $values) && array_key_exists('processor_platform_type2', $values)) {
                $query->setParameter('platform', $values['processor_platform_type2']);
            }
        }

        // setting the rest of the parameters
        foreach ($values as $key => $val) {
            if ($val != null) {
                if ($key !== "name") {
                    $query->setParameter($key, $val);
                } else {
                    $query->setParameter($key, "%$val%");
                }
            }
        }
    }

    /**
     * @return Motherboard[] Returns an array of Motherboard objects
     */
    public function findByWithJoin(array $criteria)
    {
        $arrays = array();
        $values = array();
        if($criteria == [])
            return [];
        $this->separateArraysFromValues($criteria, $arrays, $values);

        $sql = $this->prepareQuery($values, $arrays);

        $rsm = $this->initResultSetMapping();

        $em = $this->getEntityManager();
        $query = $em->createNativeQuery($sql, $rsm);

        $this->setQueryParameters($query, $values, $arrays);

        return $query->setCacheable(true)
            ->getResult();
    }

    //end of big mobo search bongaloo

    public function findSlug(string $slug): Motherboard|null
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT mobo
            FROM App\Entity\Motherboard mobo
            WHERE mobo.slug = :slug"
        )->setParameter('slug', $slug);

        return $query->getOneOrNullResult();
    }

    public function checkIdentifierExists(string|int $identifier): bool
    {
        $entityManager = $this->getEntityManager();

        if (is_int($identifier) && is_numeric($identifier)) {
            $query = $entityManager->createQuery(
                'SELECT mobo
                FROM App\Entity\Motherboard mobo
                WHERE mobo.id=:identifier'
            )->setParameter('identifier', $identifier);
        } else {
            $query = $entityManager->createQuery(
                'SELECT mobo
                FROM App\Entity\Motherboard mobo
                WHERE mobo.slug=:identifier'
            )->setParameter('identifier', $identifier);
        }

        return boolval(count($query->getResult()));
    }

    public function findAllAlphabetic(string $letter): array
    {
        $entityManager = $this->getEntityManager();
        if (empty($letter)) {
            $query = $entityManager->createQuery(
                "SELECT 'Unknown' as manName, mobo.name, mobo.id, mobo.slug, UPPER(mobo.name) as moboNameSort, mobo.lastEdited
                FROM App\Entity\Motherboard mobo
                WHERE mobo.manufacturer IS NULL
                ORDER BY moboNameSort ASC"
            );
        } else {
            $likematch = "$letter%";

            $query = $entityManager->createQuery(
                "SELECT man.name as manName, mobo.name, mobo.id, mobo.slug, UPPER(man.name) as manNameSort, UPPER(mobo.name) as moboNameSort, mobo.lastEdited
                FROM App\Entity\Motherboard mobo, App\Entity\Manufacturer man
                WHERE mobo.manufacturer=man AND UPPER(man.name) like :likeMatch
                ORDER BY manNameSort ASC, moboNameSort ASC"
            )->setParameter('likeMatch', $likematch);
        }

        return $query->getResult();
    }

    /**
     *  @return int Returns the total count of boards in the DB
     */
    public function getCount(): int
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Motherboard[] Returns the last 12 edited motherboards. Used in home page.
     */
    public function findLatest(int $maxCount = 12)
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.lastEdited', 'DESC')
            ->setMaxResults($maxCount)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Motherboard[] Returns an array of Manufacturer's name and count of board for each manufacturer
     */
    public function getManufCount(): array
    {
        $entityManager = $this->getEntityManager();
        $result = $entityManager->createQuery(
            'SELECT COALESCE(man.name, \'Unidentified\') as name, COUNT(m.id) as count
            FROM App\Entity\Motherboard m LEFT JOIN m.manufacturer man
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
     * @return Motherboard[] Returns an array of sockets and count of board for each socket
     */
    public function getSocketCount(): array
    {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('cnt', 'cnt');

        $result = $entityManager->createNativeQuery(
            "SELECT c.id, coalesce(c.name, c.type) AS name, s.cnt
            FROM cpu_socket c INNER JOIN (SELECT cpu_socket_id, count(cpu_socket_id) AS cnt FROM motherboard_cpu_socket mc GROUP BY cpu_socket_id) s ON c.id = s.cpu_socket_id
            ORDER BY cnt DESC",$rsm)->getResult();
        $finalArray = array();
        foreach ($result as $subArray) {
            $finalArray[$subArray['name']] = $subArray['cnt'];
        }
        return $finalArray;
    }

    /**
     * @return Motherboard[] Returns an array of sockets and count of board for each socket
     */
    public function getChipsetCount(): array
    {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('manuf', 'manuf');
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('part_no', 'part_no');
        $rsm->addScalarResult('cnt', 'cnt');

        $result = $entityManager->createNativeQuery(
            "SELECT c.id, man.name AS manuf, c.name, c.part_no, ch.cnt FROM chipset c
            LEFT JOIN manufacturer man ON man.id = c.manufacturer_id
            INNER JOIN (SELECT chipset_id, count(chipset_id) AS cnt FROM motherboard GROUP BY chipset_id) AS ch ON ch.chipset_id = c.id
            ORDER BY ch.cnt DESC",$rsm)->getResult();
        $finalArray = array();
        foreach ($result as $subArray) {
            $k = $subArray['manuf'] . ' ' . $subArray['part_no'];
            if ($subArray['name'] != "") {
                $k .= ' (' . $subArray['name'] . ')';
            }
            if (array_key_exists($k, $finalArray)) {
                $finalArray[$k] += $subArray['cnt'];
            } else {
                $finalArray[$k] = $subArray['cnt'];
            }
        }
        arsort($finalArray);
        return $finalArray;
    }

    /**
     * @return Motherboard[] Returns an array of sockets and count of board for each socket
     */
    public function getChipCount(): array
    {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('manuf', 'manuf');
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('part_number', 'part_number');
        $rsm->addScalarResult('cnt', 'cnt');

        $result = $entityManager->createNativeQuery(
            "SELECT c.id, man.name as manuf, c.name, c.part_number, ch.cnt FROM chip c
            LEFT JOIN manufacturer man ON man.id = c.manufacturer_id
            INNER JOIN (SELECT chip_id, count(chip_id) AS cnt FROM motherboard_chip GROUP BY chip_id) AS ch ON ch.chip_id = c.id
            ORDER BY ch.cnt DESC",$rsm)->getResult();
        $finalArray = array();
        foreach ($result as $subArray) {
            $k = $subArray['manuf'] . ' ' . $subArray['part_number'];
            if ($subArray['name'] != "") {
                $k .= ' (' . $subArray['name'] . ')';
            }
            $finalArray[$k] = $subArray['cnt'];
        }
        return $finalArray;
    }

    /**
     * @return Motherboard[] Returns an array of sockets and count of board for each socket
     */
    public function getFormFactorCount(): array
    {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('cnt', 'cnt');

        $result = $entityManager->createNativeQuery(
            "SELECT f.id, f.name, ch.cnt
            FROM form_factor f INNER JOIN (SELECT form_factor_id, count(form_factor_id) AS cnt FROM motherboard GROUP BY form_factor_id) ch ON ch.form_factor_id = f.id
            ORDER BY ch.cnt DESC",$rsm)->getResult();
        $finalArray = array();
        foreach ($result as $subArray) {
            $finalArray[$subArray['name']] = $subArray['cnt'];
        }
        return $finalArray;
    }

    /**
     * @return array Returns an array of motherboard ids
     */
    public function findAllIds()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT m.id, m.lastEdited
            FROM App\Entity\Motherboard m'
        );

        // returns an array of Product objects
        return $query->getResult();
    }
    /**
     * @return Motherboard[]
     */
    public function findAllByCreditor(int $cid): array
    {
        $entityManager = $this->getEntityManager();
        $dql   = "SELECT DISTINCT m
        FROM App:Motherboard m
        JOIN m.images mi LEFT JOIN mi.creditor c
        WHERE c.id = :cid
        ORDER BY m.name ASC";
        $query = $entityManager->createQuery($dql)->setParameter(":cid", $cid);
        return $query->getResult();
    }
}
