<?php

namespace App\Repository;

use App\Entity\CpuSocket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CpuSocket|null find($id, $lockMode = null, $lockVersion = null)
 * @method CpuSocket|null findOneBy(array $criteria, array $orderBy = null)
 * @method CpuSocket[]    findAll()
 * @method CpuSocket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CpuSocketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CpuSocket::class);
    }

    /**
     * @return CpuSocket[]
     */
    public function findBySocket(array $criteria): array
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "(LOWER(sk.name) LIKE :nameLike$key
                    OR LOWER(sk.type) LIKE :nameLike$key)";
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
                "SELECT sk
                FROM App\Entity\CpuSocket sk
                WHERE $whereString
                ORDER BY sk.name ASC, sk.type ASC"
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
        return $this->createQueryBuilder('sk')
            ->select('count(sk.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllSorted(): array
    {
        return $this->createQueryBuilder('sk')
            ->orderBy('sk.name', 'ASC')
            ->orderBy('sk.type', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
