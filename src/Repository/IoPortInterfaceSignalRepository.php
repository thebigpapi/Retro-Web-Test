<?php

namespace App\Repository;

use App\Entity\IoPortInterfaceSignal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IoPortInterfaceSignal>
 *
 * @method IoPortInterfaceSignal|null find($id, $lockMode = null, $lockVersion = null)
 * @method IoPortInterfaceSignal|null findOneBy(array $criteria, array $orderBy = null)
 * @method IoPortInterfaceSignal[]    findAll()
 * @method IoPortInterfaceSignal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IoPortInterfaceSignalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IoPortInterfaceSignal::class);
    }

    /**
     * @return IoPortInterfaceSignal[]
     */
    public function findByIoPort(array $criteria): array
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "LOWER(ip.name) LIKE :nameLike$key";
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
                "SELECT ip
                FROM App\Entity\IoPortInterfaceSignal ip
                WHERE $whereString
                ORDER BY ip.name ASC"
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
        return $this->createQueryBuilder('ip')
            ->select('count(ip.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllSorted(): array
    {
        return $this->createQueryBuilder('ip')
            ->orderBy('ip.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
