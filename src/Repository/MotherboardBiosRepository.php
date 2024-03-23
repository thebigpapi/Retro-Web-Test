<?php

namespace App\Repository;

use App\Entity\MotherboardBios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MotherboardBios|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardBios|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardBios[]    findAll()
 * @method MotherboardBios[]    findAllDistinct()
 * @method MotherboardBios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardBiosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardBios::class);
    }

    public function findAllDistinct()
    {
        return $this->createQueryBuilder('m')
            ->groupBy('m.manufacturer')
            ->getQuery()
            ->getResult();
    }
    public function getCount()
    {
        $qb = $this->createQueryBuilder('m');
        $result = $qb->select('count(m.id)')
            ->where($qb->expr()->isNotNull('m.file_name'))
            ->getQuery()
            ->getSingleScalarResult();
        return $result;
    }

    public function findBios(array $criterias)
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        if (array_key_exists('file_present', $criterias)) {
            $whereArray[] = "bios.file_name IS NOT NULL";
        }
        if (array_key_exists('manufacturer_id', $criterias)) {
            $whereArray[] = "(bios.manufacturer = :manufacturer_id)";
            $valuesArray["manufacturer_id"] = (int)$criterias['manufacturer_id'];
        }
        if (array_key_exists('mbmanufacturer_id', $criterias)) {
            $whereArray[] = "(m.manufacturer = :mbmanufacturer_id)";
            $valuesArray["mbmanufacturer_id"] = (int)$criterias['mbmanufacturer_id'];
        }
        if (array_key_exists('chipset_id', $criterias)) {
            $whereArray[] = "(m.chipset = :chipset_id)";
            $valuesArray["chipset_id"] = (int)$criterias['chipset_id'];
        }
        if (array_key_exists('bios_version', $criterias)) {
            $whereArray[] = "(LOWER(bios.boardVersion) LIKE LOWER(:biosVersion))";
            $valuesArray["biosVersion"] = "%" . $criterias['bios_version'] . "%";
        }
        if (array_key_exists('core_version', $criterias)) {
            $whereArray[] = "(LOWER(bios.coreVersion) LIKE LOWER(:coreVersion))";
            $valuesArray["coreVersion"] = "%" . $criterias['core_version'] . "%";
        }
        if (array_key_exists('post_string', $criterias)) {
            $whereArray[] = "(LOWER(bios.postString) LIKE LOWER(:postString))";
            $valuesArray["postString"] = "%" . $criterias['post_string'] . "%";
        }
        if (array_key_exists('file_name', $criterias)) {
            $whereArray[] = "(LOWER(bios.file_name) LIKE LOWER(:fileName))";
            $valuesArray["fileName"] = "%" . $criterias['file_name'] . "%";
        }
        if (array_key_exists('expansionChips', $criterias)) {
            foreach ($criterias['expansionChips'] as $key => $value) {
                $whereArray[] = "(m.id in (select m$key.id from App\Entity\Motherboard m$key JOIN m$key.expansionChips ec$key where ec$key.id=:idChip$key))";
                $valuesArray["idChip$key"] = $value;
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
                "SELECT man.name as manName, m.id, m.name, bios, bman.name as bmanName
                FROM App\Entity\MotherboardBios bios JOIN bios.manufacturer bman JOIN bios.motherboard m JOIN m.manufacturer man LEFT JOIN m.expansionChips mec
                WHERE $whereString
                ORDER BY man.name ASC, m.name ASC, bios.coreVersion ASC, manName ASC"
            );
        }

        // Setting values
        foreach ($valuesArray as $key => $value) {
            $query->setParameter($key, $value);
        }
        return $query->getResult();
    }
    public function findByHash(string $hash)
    {
        $entityManager = $this->getEntityManager();
        // Building query
        if($hash == ''){
            return [];
        }
        else{
            $query = $entityManager->createQuery(
                "SELECT man.name as manufacturer, m.id, m.name, bios.coreVersion as core, bman.name as vendor, bios.boardVersion as version, bios.file_name as file
                FROM App\Entity\MotherboardBios bios JOIN bios.manufacturer bman JOIN bios.motherboard m JOIN m.manufacturer man
                WHERE (bios.hash LIKE :hash256)"
            )->setParameter("hash256", "%" . $hash . "%");
        }
        return $query->getResult();
    }
    public function findLatest(int $maxCount = 24)
    {
        $entityManager = $this->getEntityManager();
        return $entityManager->createQuery(
            "SELECT man.name as manName, m.id, m.name, bios, bman.name as bmanName
            FROM App\Entity\MotherboardBios bios JOIN bios.manufacturer bman JOIN bios.motherboard m JOIN m.manufacturer man
            ORDER BY bios.updated_at DESC"
        )->setMaxResults($maxCount)->getResult();
    }
    public function findByString(string $string)
    {
        $entityManager = $this->getEntityManager();
        // Building query
        if($string == ''){
            return [];
        }
        else{
            $query = $entityManager->createQuery(
                "SELECT man.name as manufacturer, m.id, m.name, bios.coreVersion as core, bman.name as vendor, bios.boardVersion as version, bios.file_name as file
                FROM App\Entity\MotherboardBios bios JOIN bios.manufacturer bman JOIN bios.motherboard m JOIN m.manufacturer man
                WHERE (LOWER(bios.postString) LIKE LOWER(:postString))"
            )->setParameter("postString", "%" . $string . "%");
        }
        return $query->getResult();
    }
    public function findByFilename(string $filename1, string $filename2)
    {
        $entityManager = $this->getEntityManager();
        // Building query
        if($filename1 == '' && $filename2 == ''){
            return [];
        }
        $whereArray = array();
        $valuesArray = array();
        if($filename1 == $filename2){
            $fname = pathinfo($filename1);
            $whereArray[] = "(LOWER(bios.file_name) LIKE LOWER(:fname1) AND LOWER(bios.file_name) LIKE LOWER(:fext1))";
            $valuesArray["fname1"] = "%" . $fname['filename'] . "%";
            $valuesArray["fext1"] = "%" . $fname['extension'] . "%";
        }
        else{
            $fname1 = pathinfo($filename1);
            $fname2 = pathinfo($filename2);
            $whereArray[] = "((LOWER(bios.file_name) LIKE LOWER(:fname1) AND LOWER(bios.file_name) LIKE LOWER(:fext1)) 
                OR (LOWER(bios.file_name) LIKE LOWER(:fname2) AND LOWER(bios.file_name) LIKE LOWER(:fext2)))";
            $valuesArray["fname1"] = "%" . $fname1['filename'] . "%";
            $valuesArray["fext1"] = "%" . $fname1['extension'] . "%";
            $valuesArray["fname2"] = "%" . $fname2['filename'] . "%";
            $valuesArray["fext2"] = "%" . $fname2['extension'] . "%";
        }
        $whereString = implode(" AND ", $whereArray);
        $query = $entityManager->createQuery(
            "SELECT man.name as manufacturer, m.id, m.name, bios.coreVersion as core, bman.name as vendor, bios.boardVersion as version, bios.file_name as file
            FROM App\Entity\MotherboardBios bios JOIN bios.manufacturer bman JOIN bios.motherboard m JOIN m.manufacturer man
            WHERE $whereString"
        );
        //dd($whereString);
        foreach ($valuesArray as $key => $value) {
            $query->setParameter($key, $value);
        }
        return $query->getResult();
    }
}
