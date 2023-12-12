<?php

namespace App\Repository;

use App\Entity\Processor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Processor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Processor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Processor[]    findAll()
 * @method Processor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Processor[]    findAllOrderByManufacturer()
 */
class ProcessorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Processor::class);
    }

    /**
     * @return Processor[]
     */
    public function findAllOrderByManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT cpu
            FROM App\Entity\Processor cpu, App\Entity\Manufacturer man
            WHERE cpu.manufacturer=man
            ORDER BY cpu.name ASC'
        );

        return $query->getResult();
    }
    /**
     * @return Processor[]
     */
    public function findAllAlphabetic(string $letter): array
    {
        $entityManager = $this->getEntityManager();
        if (empty($letter)) {
            $query = $entityManager->createQuery(
                "SELECT 'Unknown' as manName, cpu.id, UPPER(cpu.name) cpuNameSort, cpu.lastEdited
                FROM App\Entity\Processor cpu
                WHERE cpu.manufacturer IS NULL
                ORDER BY cpuNameSort ASC");
        } else {
            $likematch = "$letter%";
            $query = $entityManager->createQuery(
                "SELECT cpu.id, UPPER(man.name) manNameSort, UPPER(cpu.name) cpuNameSort, cpu.lastEdited
                FROM App\Entity\Processor cpu, App\Entity\Manufacturer man
                WHERE cpu.manufacturer=man AND UPPER(man.name) like :likeMatch
                ORDER BY manNameSort ASC, cpuNameSort ASC"
                )->setParameter('likeMatch', $likematch);
        }

        return $query->getResult();
    }
    /**
     * @return Processor[]
     */
    public function findByCPU(array $criteria): array
    {

        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $whereArrayPlatform = array();
        $whereArraySocket = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('manufacturer', $criteria)) {
            $whereArray[] = "(man.id = :manufacturerId)";
            $valuesArray["manufacturerId"] = (int)$criteria['manufacturer'];
        }
        if (array_key_exists('cpuSpeed', $criteria)) {
            $whereArray[] = "(p.speed = :cpuSpeedId)";
            $valuesArray["cpuSpeedId"] = (int)$criteria['cpuSpeed'];
        }
        if (array_key_exists('fsbSpeed', $criteria)) {
            $whereArray[] = "(p.fsb = :fsbSpeedId)";
            $valuesArray["fsbSpeedId"] = (int)$criteria['fsbSpeed'];
        }
        if (array_key_exists('sockets', $criteria)) {
            foreach ($criteria['sockets'] as $key => $val) {
                $whereArraySocket[] = "(cs.id = :socketId$key)";
                $valuesArray["socketId$key"] = $val;
            }
            $whereArray[] = implode(" OR ", $whereArraySocket);
        }

        if (array_key_exists('platforms', $criteria)) {
            foreach ($criteria['platforms'] as $key => $val) {
                $whereArrayPlatform[] = "(cpu.platform = :platformId$key)";
                $valuesArray["platformId$key"] = $val;
            }
            $whereArray[] = implode(" OR ", $whereArrayPlatform);
        }

        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "(LOWER(cpu.name) LIKE :nameLike$key 
                    OR LOWER(cpu.partNumber) LIKE :nameLike$key 
                    OR LOWER(alias.name) LIKE :nameLike$key 
                    OR LOWER(alias.partNumber) LIKE :nameLike$key)";
                $valuesArray["nameLike$key"] = "%" . strtolower($val) . "%";
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
                "SELECT cpu
                FROM App\Entity\Processor cpu JOIN cpu.manufacturer man LEFT OUTER JOIN cpu.chipAliases alias INNER JOIN App\Entity\ProcessingUnit p with p.id = cpu.id join p.sockets as cs
                WHERE $whereString
                ORDER BY man.name ASC, cpu.name ASC, cpu.partNumber ASC"
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
        return $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    /**
     * @return Processor[]
     */
    public function findAllByCreditor(int $cid): array
    {
        $entityManager = $this->getEntityManager();
        $dql   = "SELECT DISTINCT cpu
        FROM App:Processor cpu
        JOIN cpu.images mi LEFT JOIN mi.creditor c
        WHERE c.id = :cid
        ORDER BY cpu.name ASC";
        $query = $entityManager->createQuery($dql)->setParameter(":cid", $cid);
        return $query->getResult();
    }
}
