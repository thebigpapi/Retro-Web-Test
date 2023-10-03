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
        if (array_key_exists('manufacturer', $criteria)) {
            $whereArray[] = "(man.id = :manufacturerId)";
            $valuesArray["manufacturerId"] = (int)$criteria['manufacturer'];
        }

        // Building where statement
        $whereString = implode(" AND ", $whereArray);

        // Building query
        $query = $entityManager->createQuery(
            "SELECT hdd
            FROM App\Entity\HardDrive hdd JOIN hdd.manufacturer man LEFT OUTER JOIN hdd.storageDeviceAliases alias
            WHERE $whereString
            ORDER BY man.name ASC, hdd.name ASC"
        );

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
}
