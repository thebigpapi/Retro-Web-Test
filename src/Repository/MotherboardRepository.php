<?php

namespace App\Repository;

use App\Entity\Motherboard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @method Motherboard|null find($id, $lockMode = null, $lockVersion = null)
 * @method Motherboard|null findOneBy(array $criteria, array $orderBy = null)
 * @method Motherboard[]    findAll()
 * @method Motherboard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Motherboard[]    findByWithJoin(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Motherboard::class);
    }

    public function findAllAlphabetic(string $letter): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT mobo
            FROM App\Entity\Motherboard mobo, App\Entity\Manufacturer man 
            WHERE mobo.manufacturer=man AND COALESCE(man.shortName, man.name) ilike :letter
            ORDER BY man.name ASC, mobo.name ASC'
        )->setParameter('letter', "$letter%");

        
        return $query->getResult();
    }

    private function separateArraysFromValues($source, &$arrays, &$values)
    {
        foreach($source as $key => $val) {
            if (is_array($val)) {
                $arrays[$key] = json_decode(json_encode($val), true);
            }
            else {
                $values[$key] = $val;
            }
        }
    }

    private function expansionSlotsToSQL($expansionSlots, &$slotVals, &$cpt)
    {
        $from = "";
        foreach ($expansionSlots as $slot) {
            $slotVals['id' . $cpt] = $slot['id'];
            
            $slotCount = "";
            if($slot['count'] != null){
                $slotCount = " AND mex.count=:slotCount" . $cpt;
                $slotVals['slotCount' . $cpt] = $slot['count']; 
                if ($cpt == 0) {
                    $from = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_expansion_slot mex ON mb.id=mex.motherboard_id 
                        WHERE mex.expansion_slot_id=:id" . $cpt . $slotCount . " 
                        ) as mot" . $cpt . " ";
                }
                else {
                    $from = $from . " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_expansion_slot mex ON mb.id = mex.motherboard_id 
                        WHERE mex.expansion_slot_id = :id" . $cpt . $slotCount . " 
                        ) as mot" . $cpt . " ON mot" . ($cpt-1) . ".id = mot" . $cpt . ".id ";
                }
            }
            else {
                if ($cpt == 0) {
                    $from = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_expansion_slot mex WHERE mex.expansion_slot_id = :id" . $cpt . $slotCount . " 
                        )) as mot" . $cpt . " ";
                }
                else {
                    $from = $from . " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_expansion_slot mex WHERE mex.expansion_slot_id = :id" . $cpt . $slotCount . " 
                        )) as mot" . $cpt . " ON mot" . ($cpt-1) . ".id = mot" . $cpt . ".id ";
                }
            }

            
            $cpt ++;
        }
        return $from;
    }

    private function ioPortsToSQL($ioPorts, &$ioVals, &$cpt)
    {
        $from = "";
        foreach ($ioPorts as &$port) {
            $ioVals['id' . $cpt] = $port['id'];
            

            $portCount = "";
            if($port['count'] != null){
                $portCount = " AND mip.count= :portCount" . $cpt;
                $ioVals['portCount'.$cpt] = $port['count']; 
                if ($cpt == 0) {
                    $from = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_io_port mip ON mb.id = mip.motherboard_id 
                        WHERE mip.io_port_id = :id" . $cpt . $portCount . " 
                        ) as mot" . $cpt . " ";
                }
                else {
                    
                    $from = $from . " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        JOIN motherboard_io_port mip ON mb.id = mip.motherboard_id 
                        WHERE mip.io_port_id = :id" . $cpt . $portCount . " 
                        ) as mot" . $cpt . " ON mot" . ($cpt-1) . ".id = mot" . $cpt . ".id ";
                }
            }
            else {
                if ($cpt == 0) {
                    $from = " ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_io_port mip WHERE mip.io_port_id = :id" . $cpt . " 
                        )) as mot" . $cpt . " ";
                }
                else {
                    
                    $from = $from . " INNER JOIN ( 
                        SELECT * 
                        FROM motherboard mb 
                        WHERE mb.id NOT IN (SELECT motherboard_id FROM motherboard_io_port mip WHERE mip.io_port_id = :id" . $cpt . " 
                        )) as mot" . $cpt . " ON mot" . ($cpt-1) . ".id = mot" . $cpt . ".id ";
                }
            }

            
            $cpt ++;
        }

        return $from;
    }

    private function valueToWhere(&$values, $key, $value) {
        if (is_null($value)) {
            unset($values[$key]);
            return $key . "_id is NULL";
        }
        elseif ($key === "name") {
            return $key . " ILIKE :$key";
        }
        else return $key ."_id =:$key";
    }

    private function valuesToWhere(&$values, &$cpt)
    {
        $where = "";
        foreach ($values as $key => $val) {
            if ($key === array_key_last($values)) {
                $where = $where . "mot0." . $this->valueToWhere($values, $key, $val);
            }
            else {
                $where = $where . "mot0." . $this->valueToWhere($values, $key, $val) . " AND ";
            }
            $cpt ++;
        }
        return $where;
    }

    private function biosToSQL($bios, &$cpt)
    {
        if ($cpt != 0) $where = " AND ";
        else $where = "";

        foreach ($bios as $key => $val){
            if ($key === array_key_last($bios))
                $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_bios bios WHERE bios.manufacturer_id=:bios$key)";
            else
                $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_bios bios WHERE bios.manufacturer_id=:bios$key) AND";
            $cpt ++;
        } 
        return $where;
    }

    private function dramToSQL($dram, &$cpt)
    {
        if ($cpt != 0) $where = " AND ";
        else $where = "";

        foreach ($dram as $key => $val){
            if ($key == array_key_last($dram))
                $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_dram_type dram WHERE dram.dram_type_id=:dram$key)";
            else
                $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_dram_type dram WHERE dram.dram_type_id=:dram$key) AND";
            $cpt ++;
        } 
        return $where;
    }

    private function initResultSetMapping()
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

        $rsm->addJoinedEntityResult('App\Entity\ProcessorPlatformType', 'pp', 'mot0', 'processorPlatformType');
        $rsm->addFieldResult('pp', 'ppt_id', 'id');
        $rsm->addFieldResult('pp', 'ppt_name', 'name');

        $rsm->addJoinedEntityResult('App\Entity\Manufacturer', 'man2', 'chp', 'manufacturer');
        $rsm->addFieldResult('man2', 'man2_id', 'id');
        $rsm->addFieldResult('man2', 'man2_name', 'name');
        $rsm->addFieldResult('man2', 'man2_short_name', 'shortName');

        return $rsm;
    }

    private function prepareSQL(array $values, array $arrays, &$slotVals, &$ioVals, array $orderBy = null, $limit = null, $offset = null)
    {
        $posFrom = 0;
        $posWhere = 0;

        $where = $this->valuesToWhere($values, $posWhere);
        $from = "FROM ";


        if (!isset($arrays["ioPorts"]) && !isset($arrays["expansionSlots"])) {
            $from = $from . "motherboard mot0";
        }
        else {
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

        if ($posWhere != 0) {
            $where = "WHERE $where";
            $whereNoChipset = "$where AND mot0.chipset_id is NULL ";
        }
        else {
            $whereNoChipset = "WHERE mot0.chipset_id is NULL ";
        }
        $orderBySQL = "";
        if ($orderBy != NULL) {
            $orderBySQL = " ORDER BY ";
            foreach($orderBy as $name => $direction) {
                if ($name == array_key_last($orderBy))
                    $orderBySQL = $orderBySQL . "$name $direction ";
                else
                    $orderBySQL = $orderBySQL . "$name $direction,";
            }
        }
        
        //LIMITE � MYSQL
        $limitSQL = "";
        if ($limit != NULL) {
            $limitSQL = " LIMIT ";
            if ($offset != NULL) {
                $limitSQL = $limitSQL . "$offset,";
            }
            $limitSQL = $limitSQL . "$limit";
            
        }
        elseif ($offset != NULL) {
            $limitSQL = "$offset,0"; //BUG
        }

        $sql = "
            SELECT mot0.*, mot0.name as mot0_name,
            man1.id as man1_id, man1.name as man1_name, man1.short_name as man1_short_name,
            chp.id as chp_id, chp.manufacturer_id as chp_man_id,
            man2.id as man2_id, man2.name as man2_name, man2.short_name as man2_short_name,
            pp.id as ppt_id, pp.name as ppt_name 
            $from 
            LEFT JOIN manufacturer man1 ON mot0.manufacturer_id = man1.id 
            JOIN chipset chp ON mot0.chipset_id = chp.id 
            JOIN manufacturer man2 ON chp.manufacturer_id = man2.id 
            JOIN processor_platform_type pp ON mot0.processor_platform_type_id = pp.id
            $where

            UNION

            SELECT mot0.*, mot0.name as mot0_name, 
            man1.id as man1_id, man1.name as man1_name, man1.short_name as man1_short_name,
            NULL, NULL, NULL, NULL,
            NULL,
            pp.id as ppt_id, pp.name as ppt_name 
            $from 
            LEFT JOIN manufacturer man1 ON mot0.manufacturer_id = man1.id 
            JOIN processor_platform_type pp ON mot0.processor_platform_type_id = pp.id
            $whereNoChipset 
            $orderBySQL
            $limitSQL
        ";
        return $sql;
    }

    private function putDataInQuery(&$query, array $values, array $arrays, $slotVals, $ioVals)
    {
        foreach ($slotVals as $key => $val){
            $query->setParameter($key, $val);
        }
        foreach ($ioVals as $key => $val){
            $query->setParameter($key, $val);
        }
        foreach ($values as $key => $val) {
            if ($val != NULL){
                if ($key !== "name")
                    $query->setParameter($key, $val);
                else {
                    $query->setParameter($key, "%$val%");
                }
                    
            }
        }
        if (isset($arrays["bios"])) {
            foreach ($arrays["bios"] as $key => $val) {
                $query->setParameter("bios$key", $val);
            }
        }
        if (isset($arrays["dram"])) {
            foreach ($arrays["dram"] as $key => $val) {
                $query->setParameter("dram$key", $val);
            }
        }
    }

    public function findByWithJoin(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $arrays = array();
        $values = array();
        $this->separateArraysFromValues($criteria, $arrays, $values);

        $slotVals = array();
        $ioVals = array();
        
        $sql = $this->prepareSQL($values, $arrays, $slotVals, $ioVals, $orderBy, $limit, $offset);
        $rsm = $this->initResultSetMapping();

        $em = $this->getEntityManager();
        $query = $em->createNativeQuery($sql, $rsm);

        $this->putDataInQuery($query, $values, $arrays, $slotVals, $ioVals);

        return $query->setCacheable(true)
            ->getResult();
    }

    public function find10Latest()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.lastEdited', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
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
