<?php

namespace App\Repository;

use App\Entity\HardDrive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HardDrive>
 *
 * @method HardDrive|null find($id, $lockMode = null, $lockVersion = null)
 * @method HardDrive|null findOneBy(array $criteria, array $orderBy = null)
 * @method HardDrive[]    findAll()
 * @method HardDrive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HardDriveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HardDrive::class);
    }

    public function save(HardDrive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HardDrive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function convertCapacity($input): array
    {
        $output = array();
        $output['valid'] = true;
        $nospaces = html_entity_decode(preg_replace("/\s+/", "", $input));
        $sign = preg_replace('/[^><=]/', '', $nospaces);
        $letters = preg_replace('/[^a-zA-Z]/', '', $nospaces);
        $numbers = preg_replace('/[^0-9]/', '', $nospaces);
        if($numbers == "")
            $output['valid'] = false;
        $output['value'] = (int)$numbers;
        $output['sign'] = '=';
        if($sign == "<")
            $output['sign'] = '<';
        if($sign == ">")
            $output['sign'] = '>';
        if($sign == ">=")
            $output['sign'] = '>=';
        if($sign == "<=")
            $output['sign'] = '<=';
        if(strtolower($letters) == strtolower("GB"))
            $output['value'] = 1024 * (int)$numbers;
        if(strtolower($letters) == strtolower("TB"))
            $output['value'] = 1048576 * (int)$numbers;
        return $output;
    }
    /**
     * @return HardDrive[]
     */
    public function findByHdd(array $criteria): array
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "(LOWER(hdd.name) LIKE :nameLike$key
                    OR LOWER(hdd.partNumber) LIKE :nameLike$key
                    OR LOWER(alias.name) LIKE :nameLike$key
                    OR LOWER(alias.partNumber) LIKE :nameLike$key)";
                $valuesArray["nameLike$key"] = "%" . strtolower($val) . "%";
            }
        }
        if (array_key_exists('capacity', $criteria)) {
            $capvalue = $this->convertCapacity($criteria['capacity']);
            if($capvalue['valid'])
                $whereArray[] = "hdd.capacity" . $capvalue['sign'] . $capvalue['value'];
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
                "SELECT hdd
                FROM App\Entity\HardDrive hdd JOIN hdd.manufacturer man LEFT OUTER JOIN hdd.storageDeviceAliases alias
                WHERE hdd.id < 10000
                ORDER BY man.name ASC, hdd.name ASC"
            );
        }
        else{
            $query = $entityManager->createQuery(
                "SELECT hdd
                FROM App\Entity\HardDrive hdd JOIN hdd.manufacturer man LEFT OUTER JOIN hdd.storageDeviceAliases alias
                WHERE $whereString
                ORDER BY man.name ASC, hdd.name ASC"
            );
        }

        // Setting values
        foreach ($valuesArray as $key => $value) {
            $query->setParameter($key, $value);
        }
        return $query->getResult();
    }
    public function getCount(): int
    {
        return $this->createQueryBuilder('h')
            ->select('count(h.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    /**
     * @return HardDrive[]
     */
    public function findAllByCreditor(int $cid): array
    {
        $entityManager = $this->getEntityManager();
        $dql   = "SELECT DISTINCT hdd
        FROM App:HardDrive hdd
        JOIN hdd.storageDeviceImages mi LEFT JOIN mi.creditor c
        WHERE c.id = :cid
        ORDER BY hdd.name ASC";
        $query = $entityManager->createQuery($dql)->setParameter(":cid", $cid);
        return $query->getResult();
    }
}
