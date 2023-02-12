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
 * @method Motherboard[]    findLatest()
 * @method Motherboard[]    find50Latest()
 */
class MotherboardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Motherboard::class);
    }

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
                "SELECT 'Unknown' as manName, mobo.name, mobo.id
                FROM App\Entity\Motherboard mobo
                WHERE mobo.manufacturer IS NULL
                ORDER BY mobo.name ASC"
            );
        } else {
            $likematch = "$letter%";

            $query = $entityManager->createQuery(
                "SELECT COALESCE(man.shortName, man.name) as manName, mobo.name, mobo.id
                FROM App\Entity\Motherboard mobo, App\Entity\Manufacturer man 
                WHERE mobo.manufacturer=man AND COALESCE(man.shortName, man.name) like :likeMatch
                ORDER BY manName ASC, mobo.name ASC"
            )->setParameter('likeMatch', $likematch);
        }

        return $query->getResult();
    }

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

    private function expansionSlotsToSQL($expansionSlots, &$slotVals, &$cpt)
    {
        $from = "";
        foreach ($expansionSlots as $key => $slot) {
            $slotVals['id' . $cpt] = $slot['id'];

            $slotCount = "";
            if (isset($slot['count'])) {
                $slotCount = " AND mex.count=:slotCount" . $cpt;
                $slotVals['slotCount' . $cpt] = $slot['count'];
                if ($cpt == 0) {
                    $from = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_expansion_slot mex ON mb.id=mex.motherboard_id 
                        WHERE mex.expansion_slot_id=:id" . $cpt . $slotCount . " 
                        ) as mot" . $cpt . " ";
                } else {
                    $from = $from . " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_expansion_slot mex ON mb.id = mex.motherboard_id 
                        WHERE mex.expansion_slot_id = :id" . $cpt . $slotCount . " 
                        ) as mot" . $cpt . " ON mot" . ($cpt - 1) . ".id = mot" . $cpt . ".id ";
                }
            } else {
                if ($cpt == 0) {
                    $from = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_expansion_slot mex 
                        WHERE mex.expansion_slot_id = :id" . $cpt . $slotCount . " 
                        )) as mot" . $cpt . " ";
                } else {
                    $from = $from . " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_expansion_slot mex 
                        WHERE mex.expansion_slot_id = :id" . $cpt . $slotCount . " 
                        )) as mot" . $cpt . " ON mot" . ($cpt - 1) . ".id = mot" . $cpt . ".id ";
                }
            }


            $cpt++;
        }
        return $from;
    }

    private function expansionSlotsToSQL2(array $expansionSlots, array $from): array
    {
        foreach ($expansionSlots as $key => $slot) {
            $fromLength = count($from);
            if (isset($slot['count'])) {
                if ($fromLength == 0) {
                    $from[] = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_expansion_slot mex ON mb.id=mex.motherboard_id 
                        WHERE mex.expansion_slot_id=:idSlot" . $key . " AND mex.count=:slotCount" . $key . " 
                        ) as mot" . $fromLength . " ";
                } else {
                    $from[] = " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_expansion_slot mex ON mb.id = mex.motherboard_id 
                        WHERE mex.expansion_slot_id = :idSlot" . $key . " AND mex.count=:slotCount" . $key . " 
                        ) as mot" . $fromLength . " ON mot" . ($fromLength - 1) . ".id = mot" . $fromLength . ".id ";
                }
            } else {
                if ($fromLength == 0) {
                    $from[] = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_expansion_slot mex 
                        WHERE mex.expansion_slot_id = :idSlot" . $key . " 
                        )) as mot" . $fromLength . " ";
                } else {
                    $from[] = " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_expansion_slot mex 
                        WHERE mex.expansion_slot_id = :idSlot" . $key . " 
                        )) as mot" . $fromLength . " ON mot" . ($fromLength - 1) . ".id = mot" . $fromLength . ".id ";
                }
            }
        }
        return $from;
    }

    private function ioPortsToSQL($ioPorts, &$ioVals, &$cpt)
    {
        $from = "";
        foreach ($ioPorts as &$port) {
            $ioVals['id' . $cpt] = $port['id'];

            $portCount = "";
            if (isset($port['count'])) {
                $portCount = " AND mip.count= :portCount" . $cpt;
                $ioVals['portCount' . $cpt] = $port['count'];
                if ($cpt == 0) {
                    $from = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_io_port mip ON mb.id = mip.motherboard_id 
                        WHERE mip.io_port_id = :id" . $cpt . $portCount . " 
                        ) as mot" . $cpt . " ";
                } else {
                    $from = $from . " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_io_port mip ON mb.id = mip.motherboard_id 
                        WHERE mip.io_port_id = :id" . $cpt . $portCount . " 
                        ) as mot" . $cpt . " ON mot" . ($cpt - 1) . ".id = mot" . $cpt . ".id ";
                }
            } else {
                if ($cpt == 0) {
                    $from = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_io_port mip 
                        WHERE mip.io_port_id = :id" . $cpt . " 
                        )) as mot" . $cpt . " ";
                } else {
                    $from = $from . " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_io_port mip 
                        WHERE mip.io_port_id = :id" . $cpt . " 
                        )) as mot" . $cpt . " ON mot" . ($cpt - 1) . ".id = mot" . $cpt . ".id ";
                }
            }


            $cpt++;
        }

        return $from;
    }

    private function ioPortsToSQL2(array $ioPorts, array $from): array
    {
        foreach ($ioPorts as $key => $port) {
            $fromLength = count($from);
            if (isset($port['count'])) {
                if ($fromLength == 0) {
                    $from[] = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_io_port mip ON mb.id = mip.motherboard_id 
                        WHERE mip.io_port_id = :idPort" . $key . " AND mip.count= :portCount" . $key . " 
                        ) as mot" . $fromLength . " ";
                } else {
                    $from[] = " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_io_port mip ON mb.id = mip.motherboard_id 
                        WHERE mip.io_port_id = :idPort" . $key . " AND mip.count= :portCount" . $key . " 
                        ) as mot" . $fromLength . " ON mot" . ($fromLength - 1) . ".id = mot" . $fromLength . ".id ";
                }
            } else {
                if ($fromLength == 0) {
                    $from[] = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_io_port mip 
                        WHERE mip.io_port_id = :idPort" . $key . " 
                        )) as mot" . $fromLength . " ";
                } else {
                    $from[] = " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_io_port mip 
                        WHERE mip.io_port_id = :idPort" . $key . " 
                        )) as mot" . $fromLength . " ON mot" . ($fromLength - 1) . ".id = mot" . $fromLength . ".id ";
                }
            }
        }

        return $from;
    }

    private function valueToWhere(&$values, $key, $value)
    {
        if (is_null($value)) {
            unset($values[$key]);
            return $key . "_id is NULL";
        } else {
            return $key . "_id =:$key";
        }
    }

    private function valueToWhere2(string $key, ?string $value): string //Warning ! Different behavior
    {
        return $key . "_id" . (is_null($value) ? " is NULL" : "=:$key");
    }

    private function valuesToWhere(&$values, &$cpt)
    {
        $where = "";
        foreach ($values as $key => $val) {
            if ($key === array_key_last($values)) {
                $where = $where . "mot0." . $this->valueToWhere($values, $key, $val);
            } else {
                $where = $where . "mot0." . $this->valueToWhere($values, $key, $val) . " AND ";
            }
            $cpt++;
        }
        return $where;
    }

    private function valuesToWhere2(array $values, array $where): array
    {
        foreach ($values as $key => $val) {
            $where[] = "mot0." . $this->valueToWhere2($key, $val);
        }
        return $where;
    }

    /*private function biosToSQL($bios, &$cpt)
    {
        if ($cpt != 0) $where = " AND ";
        else $where = "";

        foreach ($bios as $key => $val){
            if ($key === array_key_last($bios))
                $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_bios bios
                WHERE bios.manufacturer_id=:bios$key)";
            else
                $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_bios bios
                WHERE bios.manufacturer_id=:bios$key) AND";
            $cpt ++;
        }
        return $where;
    }

    private function biosToSQL2(array $bios, array $where) : array {
        foreach ($bios as $key => $val) {
            $where[] = "mot0.id IN (SELECT motherboard_id FROM motherboard_bios bios
            WHERE bios.manufacturer_id=:bios$key)";
        }
        return $where;
    }*/

    /*private function dramToSQL($dram, &$cpt)
    {
        if ($cpt != 0) $where = " AND ";
        else $where = "";

        foreach ($dram as $key => $val) {
            if ($key == array_key_last($dram)) {
                $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_dram_type dram
                WHERE dram.dram_type_id=:dram$key)";
            }
            else {
                $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_dram_type dram
                WHERE dram.dram_type_id=:dram$key) AND";
            }
            $cpt ++;
        }
        return $where;
    }

    private function dramToSQL2(array $dram, array $where): array {
        foreach ($dram as $key => $val) {
            $where[] = "mot0.id IN (SELECT motherboard_id FROM motherboard_dram_type dram
            WHERE dram.dram_type_id=:dram$key)";
        }
        return $where;
    }*/

    private function socketToSQL($socket1, $socket2, &$cpt)
    {
        if ($cpt != 0) {
            $where = " AND ";
        } else {
            $where = "";
        }
        // Two sockets
        if ($socket1 && $socket2 && $socket1 != $socket2) {
            $where = "$where mot0.id IN (SELECT socket1.motherboard_id 
            FROM motherboard_cpu_socket as socket1 
            JOIN motherboard_cpu_socket as socket2 on socket1.motherboard_id = socket2.motherboard_id 
            WHERE socket1.cpu_socket_id=:socket1 AND socket2.cpu_socket_id=:socket2)";
        } else // One socket
        {
            $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_cpu_socket 
            WHERE cpu_socket_id=:socket)";
        }
        $cpt++;
        return $where;
    }

    private function socketToSQL2($socket1, $socket2, array $where): array
    {
        // Two sockets
        if ($socket1 && $socket2 && $socket1 != $socket2) {
            $where[] = "mot0.id IN (SELECT socket1.motherboard_id 
            FROM motherboard_cpu_socket as socket1 
            JOIN motherboard_cpu_socket as socket2 on socket1.motherboard_id = socket2.motherboard_id 
            WHERE socket1.cpu_socket_id=:socket1 AND socket2.cpu_socket_id=:socket2)";
        } else { // One socket
            $where[] = "mot0.id IN (SELECT motherboard_id FROM motherboard_cpu_socket WHERE cpu_socket_id=:socket)";
        }
        return $where;
    }

    private function platformToSQL($platform1, $platform2, &$cpt)
    {
        if ($cpt != 0) {
            $where = " AND ";
        } else {
            $where = "";
        }

        // Two platforms
        if ($platform1 && $platform2 && $platform1 != $platform2) {
            $where = "$where mot0.id IN (SELECT platform1.motherboard_id 
            FROM motherboard_processor_platform_type as platform1 
            JOIN motherboard_processor_platform_type as platform2 ON
            platform1.motherboard_id = platform2.motherboard_id 
            WHERE platform1.processor_platform_type_id=:platform1 AND platform2.processor_platform_type_id=:platform2)";
        } else { // One platform
            $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_processor_platform_type 
            WHERE processor_platform_type_id=:platform)";
        }
        $cpt++;
        return $where;
    }

    private function platformToSQL2($platform1, $platform2, array $where): array
    {
        // Two platforms
        if ($platform1 && $platform2 && $platform1 != $platform2) {
            $where[] = "mot0.id IN (SELECT platform1.motherboard_id 
            FROM motherboard_processor_platform_type as platform1 
            JOIN motherboard_processor_platform_type as platform2 ON
            platform1.motherboard_id = platform2.motherboard_id 
            WHERE platform1.processor_platform_type_id=:platform1 AND platform2.processor_platform_type_id=:platform2)";
        } else { // One platform
            $where[] = "mot0.id IN (SELECT motherboard_id FROM motherboard_processor_platform_type 
            WHERE processor_platform_type_id=:platform)";
        }
        return $where;
    }

    private function initResultSetMapping(): ResultSetMapping
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('App\Entity\Motherboard', 'mot0');
        $rsm->addFieldResult('mot0', 'id', 'id');
        $rsm->addFieldResult('mot0', 'name', 'name');

        $rsm->addJoinedEntityResult('App\Entity\Manufacturer', 'man1', 'mot0', 'manufacturer');
        $rsm->addFieldResult('man1', 'man1_id', 'id');
        $rsm->addFieldResult('man1', 'man1_name', 'name');
        $rsm->addFieldResult('man1', 'man1_short_name', 'shortName');

        $rsm->addJoinedEntityResult('App\Entity\Chipset', 'chp', 'mot0', 'chipset');
        $rsm->addFieldResult('chp', 'chp_id', 'id');

        $rsm->addJoinedEntityResult('App\Entity\Manufacturer', 'man2', 'chp', 'manufacturer');
        $rsm->addFieldResult('man2', 'man2_id', 'id');
        $rsm->addFieldResult('man2', 'man2_name', 'name');
        $rsm->addFieldResult('man2', 'man2_short_name', 'shortName');

        return $rsm;
    }

    private function prepareSQL(array $values, array $arrays, &$slotVals, &$ioVals)
    {
        $posFrom = 0;
        $posWhere = 0;

        // Gathering name and manufacturer which are handled differently compared to other values
        if (isset($values['name'])) {
            $name = $values['name'];
            unset($values['name']);
        }
        if (isset($values['manufacturer'])) {
            $manufacturer = $values['manufacturer'];
            unset($values['manufacturer']);
        }
        if (array_key_exists('chipsetManufacturer', $values)) {
            $chipsetManufacturer = $values['chipsetManufacturer'];
            unset($values['chipsetManufacturer']);
        }
        if (isset($values['cpu_socket1'])) {
            $socket1 = $values['cpu_socket1'];
            unset($values['cpu_socket1']);
        }
        if (isset($values['cpu_socket2'])) {
            $socket2 = $values['cpu_socket2'];
            unset($values['cpu_socket2']);
        }
        if (isset($values['processor_platform_type1'])) {
            $platform1 = $values['processor_platform_type1'];
            unset($values['processor_platform_type1']);
        }
        if (isset($values['processor_platform_type2'])) {
            $platform2 = $values['processor_platform_type2'];
            unset($values['processor_platform_type2']);
        }

        $where = $this->valuesToWhere($values, $posWhere);

        // Treating name and manufacturer differently to other values (to search into actual motherboard name and alias)
        if (isset($name) && $name != null) {
            if ($posWhere != 0) {
                if (isset($manufacturer)) {
                    if ($manufacturer == null) {
                        //WORKS
                        $where = "$where AND ((mot0.name ILIKE :name AND mot0.manufacturer_id IS NULL) 
                        OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma 
                        WHERE ma.name ILIKE :name AND ma.manufacturer_id IS NULL)) ";
                        $posWhere++;
                    } else {
                        //WORKS
                        $where = "$where AND ((mot0.name ILIKE :name AND mot0.manufacturer_id = :manufacturer) 
                        OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma 
                        WHERE ma.name ILIKE :name AND ma.manufacturer_id = :manufacturer)) ";
                        $posWhere++;
                    }
                } else {
                    //WORKS
                    $where = "$where AND (mot0.name ILIKE :name OR mot0.id IN 
                    (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.name ILIKE :name)) ";
                    $posWhere++;
                }
            } else {
                if (isset($manufacturer)) {
                    if ($manufacturer == null) {
                        //WORKS
                        $where = "((mot0.name ILIKE :name AND mot0.manufacturer_id IS NULL) OR mot0.id IN 
                        (SELECT motherboard_id FROM motherboard_alias AS ma 
                        WHERE ma.name ILIKE :name AND ma.manufacturer_id IS NULL)) ";
                        $posWhere++;
                    } else {
                        //WORKS
                        $where = "((mot0.name ILIKE :name AND mot0.manufacturer_id = :manufacturer) OR mot0.id IN 
                        (SELECT motherboard_id FROM motherboard_alias AS ma 
                        WHERE ma.name ILIKE :name AND ma.manufacturer_id = :manufacturer)) ";
                        $posWhere++;
                    }
                } else {
                    //WORKS
                    $where = "((mot0.name ILIKE :name) OR mot0.id IN 
                    (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.name ILIKE :name)) ";
                    $posWhere++;
                }
            }
        } elseif (isset($manufacturer)) {
            if ($manufacturer == null) {
                if ($posWhere != 0) {
                    $where = "$where AND ( mot0.manufacturer_id IS NULL OR mot0.id IN 
                    (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id IS NULL)) ";
                    $posWhere++;
                } else {
                    //WORKS
                    $where = "( mot0.manufacturer_id IS NULL OR mot0.id IN 
                    (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id IS NULL)) ";
                    $posWhere++;
                }
            } else {
                if ($posWhere != 0) {
                    $where = "$where AND ( mot0.manufacturer_id = :manufacturer OR mot0.id IN 
                    (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id = :manufacturer)) ";
                    $posWhere++;
                } else {
                    $where = "( mot0.manufacturer_id = :manufacturer OR mot0.id IN 
                    (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id = :manufacturer)) ";
                    $posWhere++;
                }
            }
        }

        $from = "FROM ";


        if (!isset($arrays["ioPorts"]) && !isset($arrays["expansionSlots"])) {
            $from = $from . "motherboard mot0";
        } else {
            if (isset($arrays["expansionSlots"])) {
                $from = $from . $this->expansionSlotsToSQL($arrays['expansionSlots'], $slotVals, $posFrom);
            }
            if (isset($arrays["ioPorts"])) {
                $from = $from . $this->ioPortsToSQL($arrays['ioPorts'], $ioVals, $posFrom);
            }
        }
        if (isset($arrays["bios"])) {
            $where = $where . $this->biosToSQL($arrays['bios'], $posWhere);
        }
        if (isset($arrays["dram"])) {
            $where = $where . $this->dramToSQL($arrays['dram'], $posWhere);
        }
        if (isset($socket1) && isset($socket2)) {
            $where = $where . $this->socketToSQL($socket1, $socket2, $posWhere);
        } elseif (isset($socket1)) {
            $where = $where . $this->socketToSQL($socket1, null, $posWhere);
        } elseif (isset($socket2)) {
            $where = $where . $this->socketToSQL($socket2, null, $posWhere);
        }

        if (isset($platform1) && isset($platform2)) {
            $where = $where . $this->platformToSQL($platform1, $platform2, $posWhere);
        } elseif (isset($platform1)) {
            $where = $where . $this->platformToSQL($platform1, null, $posWhere);
        } elseif (isset($platform2)) {
            $where = $where . $this->platformToSQL($platform2, null, $posWhere);
        }

        if ($posWhere != 0) {
            $where = "WHERE $where";
            $whereNoChipset = "$where AND mot0.chipset_id is NULL ";
        } else {
            $whereNoChipset = "WHERE mot0.chipset_id is NULL ";
        }

        if (isset($chipsetManufacturer)) {
            if ($posWhere != 0) {
                $where = "$where AND chp.manufacturer_id=:chipsetManufacturer";
            } else {
                $where = "WHERE chp.manufacturer_id=:chipsetManufacturer ";
            }
        }

        $sql = "
            SELECT mot0.*, mot0.name as mot0_name,
            man1.id as man1_id, man1.name as man1_name, man1.short_name as man1_short_name,
            chp.id as chp_id, chp.manufacturer_id as chp_man_id,
            man2.id as man2_id, man2.name as man2_name, man2.short_name as man2_short_name
            $from 
            LEFT JOIN manufacturer man1 ON mot0.manufacturer_id = man1.id 
            JOIN chipset chp ON mot0.chipset_id = chp.id 
            JOIN manufacturer man2 ON chp.manufacturer_id = man2.id 
            $where

        ";

        $noChipset = " SELECT mot0.*, mot0.name as mot0_name, 
        man1.id as man1_id, man1.name as man1_name, man1.short_name as man1_short_name,
        NULL, NULL, NULL, NULL,
        NULL
        $from 
        LEFT JOIN manufacturer man1 ON mot0.manufacturer_id = man1.id 
        $whereNoChipset 
        ";

        if (array_key_exists('chipsetManufacturer', get_defined_vars())) { // Chipset manufacturer searched
            if ($chipsetManufacturer == null) { // Motherboards with no chipset
                $sql = "$noChipset";
            } else { // Motherboards with and without a chipset
                $sql .= " UNION $noChipset";
            }
        }

        $sql .= "ORDER BY man1_name ASC, mot0_name ASC";

        return $sql;
    }

    private function prepareSQL2(array $values, array $arrays): string
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

        // Creating from statements
        $from = array();

        if (!array_key_exists("ioPorts", $arrays) && !array_key_exists("expansionSlots", $arrays)) {
            $from[] = "motherboard mot0";
        } else {
            if (array_key_exists("expansionSlots", $arrays)) {
                $from = $this->expansionSlotsToSQL2($arrays['expansionSlots'], $from);
            }
            if (array_key_exists("ioPorts", $arrays)) {
                $from = $this->ioPortsToSQL2($arrays['ioPorts'], $from);
            }
        }

        $from[] = "LEFT JOIN manufacturer man1 ON mot0.manufacturer_id = man1.id ";

        // Creating where statements
        $where = $this->valuesToWhere2($values, array());

        // Searching name and manufacturer into actual motherboard name and alias
        if (isset($name)) {
            if (array_key_exists('manufacturer', get_defined_vars())) {
                if (is_null($manufacturer)) {
                    $where[] = "((mot0.name ILIKE :name AND mot0.manufacturer_id IS NULL) OR mot0.id IN 
                    (SELECT motherboard_id FROM motherboard_alias AS ma 
                    WHERE ma.name ILIKE :name AND ma.manufacturer_id IS NULL)) ";
                } else {
                    $where[] = "((mot0.name ILIKE :name AND mot0.manufacturer_id = :manufacturer) OR mot0.id IN 
                    (SELECT motherboard_id FROM motherboard_alias AS ma 
                    WHERE ma.name ILIKE :name AND ma.manufacturer_id = :manufacturer)) ";
                }
            } else {
                $where[] = "((mot0.name ILIKE :name) OR mot0.id IN 
                (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.name ILIKE :name)) ";
            }
        } elseif (array_key_exists('manufacturer', get_defined_vars())) {
            if (is_null($manufacturer)) {
                $where[] = "( mot0.manufacturer_id IS NULL OR mot0.id IN 
                (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id IS NULL)) ";
            } else {
                $where[] = "( mot0.manufacturer_id = :manufacturer OR mot0.id IN 
                (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id = :manufacturer)) ";
            }
        }

        if (array_key_exists("bios", $arrays)) {
            $where = $this->biosToSQL2($arrays['bios'], $where);
        }
        if (array_key_exists("dram", $arrays)) {
            $where = $this->dramToSQL2($arrays['dram'], $where);
        }
        if (array_key_exists('socket1', get_defined_vars()) && array_key_exists('socket2', get_defined_vars())) {
            $where = $this->socketToSQL2($socket1, $socket2, $where);
        } elseif (array_key_exists('socket1', get_defined_vars())) {
            $where = $this->socketToSQL2($socket1, null, $where);
        } elseif (array_key_exists('socket2', get_defined_vars())) {
            $where = $this->socketToSQL2($socket2, null, $where);
        }

        if (array_key_exists('platform1', get_defined_vars()) && array_key_exists('platform2', get_defined_vars())) {
            $where = $this->platformToSQL2($platform1, $platform2, $where);
        } elseif (array_key_exists('platform1', get_defined_vars())) {
            $where = $this->platformToSQL2($platform1, null, $where);
        } elseif (array_key_exists('platform2', get_defined_vars())) {
            $where = $this->platformToSQL2($platform2, null, $where);
        }

        // Creating where statement for boards without a chipset
        $whereNoChipset = $where;
        $whereNoChipset[] = "mot0.chipset_id is NULL ";

        // Adding one last where statement for queries looking for the chipset manufacturer
        if (array_key_exists('chipsetManufacturer', get_defined_vars())) {
            $where[] = "chp.manufacturer_id=:chipsetManufacturer ";
        }

        // Turning from and where arrays to SQL statements

        $fromSql = "FROM " . implode(" ", $from);

        $whereSQL = (!empty($where)) ? "WHERE " . implode(" AND ", $where) : "";

        $whereNoChipsetSQL = (!empty($whereNoChipset)) ? "WHERE " . implode(" AND ", $whereNoChipset) : "";

        // Building SQL query
        $sql = "
            SELECT mot0.*, mot0.name as mot0_name,
            man1.id as man1_id, man1.name as man1_name, man1.short_name as man1_short_name,
            chp.id as chp_id, chp.manufacturer_id as chp_man_id,
            man2.id as man2_id, man2.name as man2_name, man2.short_name as man2_short_name
            $fromSql 
            JOIN chipset chp ON mot0.chipset_id = chp.id 
            JOIN manufacturer man2 ON chp.manufacturer_id = man2.id 
            $whereSQL 

        ";

        $noChipset = " SELECT mot0.*, mot0.name as mot0_name, 
        man1.id as man1_id, man1.name as man1_name, man1.short_name as man1_short_name,
        NULL, NULL, NULL, NULL,
        NULL
        $fromSql 
        $whereNoChipsetSQL 
        ";

        if (array_key_exists('chipsetManufacturer', get_defined_vars())) { // Chipset manufacturer searched
            if (is_null($chipsetManufacturer)) { // Motherboards with no chipset
                $sql = "$noChipset";
            }
        } else { // Motherboards with and without a chipset
            $sql .= " UNION $noChipset";
        }

        $sql .= "ORDER BY man1_name ASC, mot0_name ASC";

        return $sql;
    }

    private function putDataInQuery(&$query, array $values, array $arrays, $slotVals, $ioVals)
    {
        foreach ($slotVals as $key => $val) {
            $query->setParameter($key, $val);
        }
        foreach ($ioVals as $key => $val) {
            $query->setParameter($key, $val);
        }
        if (
            isset($values['cpu_socket1'])
            &&
            isset($values['cpu_socket2'])
            &&
            $values['cpu_socket1'] != $values['cpu_socket2']
        ) {
            $query->setParameter('socket1', $values['cpu_socket1']);
            $query->setParameter('socket2', $values['cpu_socket2']);
        } else {
            if (isset($values['cpu_socket1']) && !isset($values['cpu_socket2'])) {
                $query->setParameter('socket', $values['cpu_socket1']);
            } elseif (isset($values['cpu_socket2']) && !isset($values['cpu_socket1'])) {
                $query->setParameter('socket', $values['cpu_socket2']);
            } elseif (isset($values['cpu_socket2']) && isset($values['cpu_socket1'])) {
                $query->setParameter('socket', $values['cpu_socket1']);
            }
        }
        if (
            isset($values['processor_platform_type1'])
            &&
            isset($values['processor_platform_type2'])
            &&
            $values['processor_platform_type1'] != $values['processor_platform_type2']
        ) {
            $query->setParameter('platform1', $values['processor_platform_type1']);
            $query->setParameter('platform2', $values['processor_platform_type2']);
        } else {
            if (isset($values['processor_platform_type1']) && !isset($values['processor_platform_type2'])) {
                $query->setParameter('platform', $values['processor_platform_type1']);
            } elseif (isset($values['processor_platform_type2']) && !isset($values['processor_platform_type1'])) {
                $query->setParameter('platform', $values['processor_platform_type2']);
            } elseif (isset($values['processor_platform_type2']) && isset($values['processor_platform_type1'])) {
                $query->setParameter('platform', $values['processor_platform_type1']);
            }
        }
        foreach ($values as $key => $val) {
            if ($val != null) {
                if ($key !== "name") {
                    $query->setParameter($key, $val);
                } else {
                    $query->setParameter($key, "%$val%");
                }
            }
        }
        /*
        if (isset($arrays["bios"])) {
            foreach ($arrays["bios"] as $key => $val) {
                $query->setParameter("bios$key", $val);
            }
        }
        if (isset($arrays["dram"])) {
            foreach ($arrays["dram"] as $key => $val) {
                $query->setParameter("dram$key", $val);
            }
        }*/
    }

    private function putDataInQuery2(NativeQuery &$query, array $values, array $arrays): void
    {
        // Putting ids (and count when it exists) for expansion slots
        if (array_key_exists("expansionSlots", $arrays)) {
            foreach ($arrays['expansionSlots'] as $key => $val) {
                $query->setParameter("idSlot" . $key, $val['id']);
                if (array_key_exists("count", $val)) {
                    $query->setParameter("slotCount" . $key, $val['count']);
                }
            }
        }

        // Putting ids (and count when it exists for io ports)
        if (array_key_exists("ioPorts", $arrays)) {
            foreach ($arrays['ioPorts'] as $key => $val) {
                $query->setParameter("idPort" . $key, $val['id']);
                if (array_key_exists("count", $val)) {
                    $query->setParameter("portCount" . $key, $val['count']);
                }
            }
        }

        // Putting ids for sockets when two sockets are detected
        if (
            array_key_exists('cpu_socket1', $values)
            &&
            array_key_exists('cpu_socket2', $values) && $values['cpu_socket1'] != $values['cpu_socket2']
        ) {
            $query->setParameter('socket1', $values['cpu_socket1']);
            $query->setParameter('socket2', $values['cpu_socket2']);
        } else { // Putting id for socket when one socket is detected
            if (array_key_exists('cpu_socket1', $values) && !array_key_exists('cpu_socket2', $values)) {
                $query->setParameter('socket', $values['cpu_socket1']);
            } elseif (array_key_exists('cpu_socket2', $values) && !array_key_exists('cpu_socket1', $values)) {
                $query->setParameter('socket', $values['cpu_socket2']);
            } elseif (array_key_exists('cpu_socket2', $values) && array_key_exists('cpu_socket1', $values)) {
                $query->setParameter('socket', $values['cpu_socket1']);
            }
        }

        // Putting ids for platforms when two platforms are detected
        if (
            array_key_exists('processor_platform_type1', $values)
            &&
            array_key_exists('processor_platform_type2', $values)
            &&
            $values['processor_platform_type1'] != $values['processor_platform_type2']
        ) {
            $query->setParameter('platform1', $values['processor_platform_type1']);
            $query->setParameter('platform2', $values['processor_platform_type2']);
        } else { // Putting id for platfomr when one platform is detected
            if (
                array_key_exists('processor_platform_type1', $values)
                &&
                !array_key_exists('processor_platform_type2', $values)
            ) {
                $query->setParameter('platform', $values['processor_platform_type1']);
            } elseif (
                array_key_exists('processor_platform_type2', $values)
                &&
                !array_key_exists('processor_platform_type1', $values)
            ) {
                $query->setParameter('platform', $values['processor_platform_type2']);
            } elseif (
                array_key_exists('processor_platform_type2', $values)
                &&
                array_key_exists('processor_platform_type1', $values)
            ) {
                $query->setParameter('platform', $values['processor_platform_type1']);
            }
        }

        // Putting values for the remaining values
        foreach ($values as $key => $val) {
            if ($val != null) {
                if ($key !== "name") {
                    $query->setParameter($key, $val);
                } else {
                    $query->setParameter($key, "%$val%");
                }
            }
        }
        /*
        if (array_key_exists("bios", $arrays)) {
            foreach ($arrays["bios"] as $key => $val) {
                $query->setParameter("bios$key", $val);
            }
        }
        if (isset($arrays["dram"])) {
            foreach ($arrays["dram"] as $key => $val) {
                $query->setParameter("dram$key", $val);
            }
        }*/
    }

    /**
     * @return Motherboard[] Returns an array of Motherboard objects
     */
    public function findByWithJoin(array $criteria)
    {
        $arrays = array();
        $values = array();
        $this->separateArraysFromValues($criteria, $arrays, $values);

        $sql = $this->prepareSQL2($values, $arrays);

        $rsm = $this->initResultSetMapping();

        $em = $this->getEntityManager();
        $query = $em->createNativeQuery($sql, $rsm);

        $this->putDataInQuery2($query, $values, $arrays);

        return $query->setCacheable(true)
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
     * @return Motherboard[] Returns an array of Motherboard objects
     */
    public function findLatest()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.lastEdited', 'DESC')
            ->setMaxResults(12)
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
            'SELECT COALESCE(COALESCE(man.shortName, man.name), \'Unidentified\') as name, COUNT(m.id) as count
            FROM App\Entity\Motherboard m LEFT JOIN m.manufacturer man 
            GROUP BY man
            ORDER BY count DESC'
        )
            ->getResult();

        $finalArray = array();

        foreach ($result as $subArray) {
            $finalArray[$subArray['name']] = $subArray['count'];
        };

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

    // /**
    //  * @return Motherboard[] Returns an array of Motherboard objects
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
    public function findOneBySomeField($value): ?Motherboard
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
