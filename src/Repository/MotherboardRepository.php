<?php

namespace App\Repository;

use App\Entity\Motherboard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
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
        if (empty($letter)) {
            $query = $entityManager->createQuery(
                "SELECT mobo
                FROM App\Entity\Motherboard mobo 
                WHERE mobo.manufacturer IS NULL
                ORDER BY mobo.name ASC"
            );
        }
        else {
            $likematch = "$letter%";
            
            $query = $entityManager->createQuery(
                "SELECT mobo
                FROM App\Entity\Motherboard mobo, App\Entity\Manufacturer man 
                WHERE mobo.manufacturer=man AND COALESCE(man.shortName, man.name) like :likeMatch
                ORDER BY man.name ASC, mobo.name ASC"
            )->setParameter('likeMatch', $likematch);
        }

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

    private function socketToSQL($socket1, $socket2, &$cpt)
    {
        if ($cpt != 0) $where = " AND ";
        else $where = "";
        // Two sockets
        if($socket1 && $socket2 && $socket1 != $socket2)
        {
            $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_cpu_socket WHERE cpu_socket_id=:socket1 OR cpu_socket_id=:socket2)";
        }
        else // One socket
        {
            $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_cpu_socket WHERE cpu_socket_id=:socket)";
        }
        $cpt ++;
        return $where;
    }

    private function platformToSQL($platform1, $platform2, &$cpt)
    {
        if ($cpt != 0) $where = " AND ";
        else $where = "";

        // Two platforms
        if($platform1 && $platform2 && $platform1 != $platform2)
        {
            $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_processor_platform_type WHERE processor_platform_type_id=:platform1 OR processor_platform_type_id=:platform2)";
        }
        else // One platform
        {
            $where = "$where mot0.id IN (SELECT motherboard_id FROM motherboard_processor_platform_type WHERE processor_platform_type_id=:platform)";
        }
        $cpt ++;
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

        $rsm->addJoinedEntityResult('App\Entity\Manufacturer', 'man2', 'chp', 'manufacturer');
        $rsm->addFieldResult('man2', 'man2_id', 'id');
        $rsm->addFieldResult('man2', 'man2_name', 'name');
        $rsm->addFieldResult('man2', 'man2_short_name', 'shortName');

        return $rsm;
    }

    private function prepareSQL(array $values, array $arrays, &$slotVals, &$ioVals, array $orderBy = null)
    {
        //dd("test");
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
        if(array_key_exists('chipsetManufacturer',$values)) {
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
                if(isset($manufacturer)) {
                    if($manufacturer == null) {
                        //WORKS
                        $where = "$where AND ((mot0.name ILIKE :name AND mot0.manufacturer_id IS NULL) OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.name ILIKE :name AND ma.manufacturer_id IS NULL)) ";
                        $posWhere ++;
                    }
                    else {
                        //WORKS
                        $where = "$where AND ((mot0.name ILIKE :name AND mot0.manufacturer_id = :manufacturer) OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.name ILIKE :name AND ma.manufacturer_id = :manufacturer)) ";
                        $posWhere ++;
                    }
                }
                else {
                    //WORKS
                    $where = "$where AND (mot0.name ILIKE :name OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.name ILIKE :name)) ";
                    $posWhere ++;
                }
            }
            else {
                if(isset($manufacturer)) {
                    if($manufacturer == null) {
                        //WORKS
                        $where = "((mot0.name ILIKE :name AND mot0.manufacturer_id IS NULL) OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.name ILIKE :name AND ma.manufacturer_id IS NULL)) ";
                        $posWhere ++;
                    }
                    else {
                        //WORKS
                        $where = "((mot0.name ILIKE :name AND mot0.manufacturer_id = :manufacturer) OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.name ILIKE :name AND ma.manufacturer_id = :manufacturer)) ";
                        $posWhere ++;
                    }
                }
                else {
                    //WORKS 
                    $where = "((mot0.name ILIKE :name) OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.name ILIKE :name)) ";
                    $posWhere ++;
                }
            }
        }
        else if (isset($manufacturer)) {
            if($manufacturer == null) {
                if ($posWhere != 0) {
                    $where = "$where AND ( mot0.manufacturer_id IS NULL OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id IS NULL)) ";
                    $posWhere ++;
                }
                else {
                    //WORKS
                    $where = "( mot0.manufacturer_id IS NULL OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id IS NULL)) ";
                    $posWhere ++;
                }
            }
            else {
                if ($posWhere != 0) {
                    $where = "$where AND ( mot0.manufacturer_id = :manufacturer OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id = :manufacturer)) ";
                    $posWhere ++;
                }
                else {
                    $where = "( mot0.manufacturer_id = :manufacturer OR mot0.id IN (SELECT motherboard_id FROM motherboard_alias AS ma WHERE ma.manufacturer_id = :manufacturer)) ";
                    $posWhere ++;
                }
            }
        }

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
        if (isset($socket1) && isset($socket2)) {
            $where = $where . $this->socketToSQL($socket1, $socket2, $posWhere);
        }
        else if (isset($socket1)) {
            $where = $where . $this->socketToSQL($socket1, null, $posWhere);
        }
        else if (isset($socket2)) {
            $where = $where . $this->socketToSQL($socket2, null, $posWhere);
        }

        if (isset($platform1) && isset($platform2)) {
            $where = $where . $this->platformToSQL($platform1, $platform2, $posWhere);
        }
        else if (isset($platform1)) {
            $where = $where . $this->platformToSQL($platform1, null, $posWhere);
        }
        else if (isset($platform2)) {
            $where = $where . $this->platformToSQL($platform2, null, $posWhere);
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

        if(isset($chipsetManufacturer))
        {
            if ($posWhere!=0)
            {
                $where = "$where AND chp.manufacturer_id=:chipsetManufacturer";
            }
            else {
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
        ;
        if (array_key_exists('chipsetManufacturer', get_defined_vars())) // Chipset manufacturer searched
            if($chipsetManufacturer == null) // Motherboards with no chipset
                $sql = "$noChipset $orderBySQL"; 
            else // Motherboards with a chipset
                $sql = "$sql $orderBySQL";            
        else // Motherboards with and without a chipset
            $sql = "$sql UNION $noChipset $orderBySQL"; 

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
        if (isset($values['cpu_socket1']) && isset($values['cpu_socket2']) && $values['cpu_socket1'] != $values['cpu_socket2']) {
            $query->setParameter('socket1', $values['cpu_socket1']);
            $query->setParameter('socket2', $values['cpu_socket2']);
        }
        else {
            if (isset($values['cpu_socket1']) && !isset($values['cpu_socket2'])) {
                $query->setParameter('socket', $values['cpu_socket1']);
            }
            else if (isset($values['cpu_socket2']) && !isset($values['cpu_socket1'])){
                $query->setParameter('socket', $values['cpu_socket2']);
            }
            else if (isset($values['cpu_socket2']) && isset($values['cpu_socket1'])){
                $query->setParameter('socket', $values['cpu_socket1']);
            }
        }
        if (isset($values['processor_platform_type1']) && isset($values['processor_platform_type2']) && $values['processor_platform_type1'] != $values['processor_platform_type2']) {
            $query->setParameter('platform1', $values['processor_platform_type1']);
            $query->setParameter('platform2', $values['processor_platform_type2']);
        }
        else {
            if (isset($values['processor_platform_type1']) && !isset($values['processor_platform_type2'])) {
                $query->setParameter('platform', $values['processor_platform_type1']);
            }
            else if (isset($values['processor_platform_type2']) && !isset($values['processor_platform_type1'])) {
                $query->setParameter('platform', $values['processor_platform_type2']);
            }
            else if (isset($values['processor_platform_type2']) && isset($values['processor_platform_type1'])) {
                $query->setParameter('platform', $values['processor_platform_type1']);
            }
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

    public function findByWithJoin(array $criteria, array $orderBy = null)
    {
        //throw new Exception("test");
        $arrays = array();
        $values = array();
        $this->separateArraysFromValues($criteria, $arrays, $values);
        
        // Saving name and manufacturer for later use
        if(isset($values['name']) && $values['name'] != null)
            $name = $values['name'];
        if(isset($values['manufacturer']) && $values['manufacturer'] != null)
            $manufacturer = $values['manufacturer'];

        $slotVals = array();
        $ioVals = array();
        
        $sql = $this->prepareSQL($values, $arrays, $slotVals, $ioVals, $orderBy);
        
        $rsm = $this->initResultSetMapping();

        $em = $this->getEntityManager();
        $query = $em->createNativeQuery($sql, $rsm);

        // Putting name and manufacturer back
        if(isset($name))
            $values['name'] = $name;
        if(isset($manufacturer))
            $values['manufacturer'] = $manufacturer;

        $this->putDataInQuery($query, $values, $arrays, $slotVals, $ioVals);

        return $query->setCacheable(true)
            ->getResult();
    }

    public function getCount()
    {
        return $this->createQueryBuilder('m')
        ->select('count(m.id)')
        ->getQuery()
        ->getSingleScalarResult();
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

    public function find50Latest()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.lastEdited', 'DESC')
            ->setMaxResults(50)
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
