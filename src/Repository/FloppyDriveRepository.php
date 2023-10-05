<?php

namespace App\Repository;

use App\Entity\FloppyDrive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FloppyDrive>
 *
 * @method FloppyDrive|null find($id, $lockMode = null, $lockVersion = null)
 * @method FloppyDrive|null findOneBy(array $criteria, array $orderBy = null)
 * @method FloppyDrive[]    findAll()
 * @method FloppyDrive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FloppyDriveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FloppyDrive::class);
    }

    public function save(FloppyDrive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FloppyDrive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
     /**
     * @return FloppyDrive[]
     */
    public function findByFdd(array $criteria): array
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "(LOWER(fdd.name) LIKE :nameLike$key
                    OR LOWER(fdd.partNumber) LIKE :nameLike$key
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
        if($whereArray == []){
            $query = $entityManager->createQuery(
                "SELECT fdd
                FROM App\Entity\FloppyDrive fdd JOIN fdd.manufacturer man LEFT OUTER JOIN fdd.storageDeviceAliases alias
                ORDER BY man.name ASC, fdd.name ASC"
            );
        }
        else{
            $query = $entityManager->createQuery(
                "SELECT fdd
                FROM App\Entity\FloppyDrive fdd JOIN fdd.manufacturer man LEFT OUTER JOIN fdd.storageDeviceAliases alias
                WHERE $whereString
                ORDER BY man.name ASC, fdd.name ASC"
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
        return $this->createQueryBuilder('f')
            ->select('count(f.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
