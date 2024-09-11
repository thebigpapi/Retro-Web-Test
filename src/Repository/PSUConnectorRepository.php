<?php

namespace App\Repository;

use App\Entity\PSUConnector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PSUConnector|null find($id, $lockMode = null, $lockVersion = null)
 * @method PSUConnector|null findOneBy(array $criteria, array $orderBy = null)
 * @method PSUConnector[]    findAll()
 * @method PSUConnector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PSUConnectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PSUConnector::class);
    }

    /**
     * @return PSUConnector[]
     */
    public function findByPowerConnector(array $criteria): array
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "LOWER(pw.name) LIKE :nameLike$key";
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
                "SELECT pw
                FROM App\Entity\PSUConnector pw
                WHERE $whereString
                ORDER BY pw.name ASC"
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
        return $this->createQueryBuilder('pw')
            ->select('count(pw.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllSorted(): array
    {
        return $this->createQueryBuilder('pw')
            ->orderBy('pw.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
