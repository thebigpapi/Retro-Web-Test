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
        $likematch = "$letter%";
        $query = $entityManager->createQuery(
            "SELECT UPPER(man.name) manNameSort, cpu
            FROM App\Entity\Processor cpu, App\Entity\Manufacturer man
            WHERE cpu.manufacturer=man AND UPPER(man.name) like :likeMatch
            ORDER BY manNameSort ASC, cpu.name ASC"
        )->setParameter('likeMatch', $likematch);

        $outputArray = [];
        foreach ($query->getResult() as $res) {
            $outputArray[] = $res[0];
        };
        return $outputArray;
    }
    /**
     * @return Processor[]
     */
    public function findByCPU(array $criteria): array
    {

        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('manufacturer', $criteria)) {
            $whereArray[] = "(man.id = :manufacturerId)";
            $valuesArray["manufacturerId"] = (int)$criteria['manufacturer'];
        }

        if (array_key_exists('platform', $criteria)) {
            $whereArray[] = "(cpu.platform = :platformId)";
            $valuesArray["platformId"] = (int)$criteria['platform'];
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
            $query = $entityManager->createQuery(
                "SELECT cpu
                FROM App\Entity\Processor cpu JOIN cpu.manufacturer man LEFT OUTER JOIN cpu.chipAliases alias LEFT JOIN App\Entity\ProcessingUnit p WITH p.platform = cpu.platform
                ORDER BY man.name ASC, cpu.name ASC, cpu.partNumber ASC"
            );
        }
        else{
            $query = $entityManager->createQuery(
                "SELECT cpu
                FROM App\Entity\Processor cpu JOIN cpu.manufacturer man LEFT OUTER JOIN cpu.chipAliases alias LEFT JOIN App\Entity\ProcessingUnit p WITH p.platform = cpu.platform
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
}
