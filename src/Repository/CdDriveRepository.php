<?php

namespace App\Repository;

use App\Entity\CdDrive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CdDrive>
 *
 * @method CdDrive|null find($id, $lockMode = null, $lockVersion = null)
 * @method CdDrive|null findOneBy(array $criteria, array $orderBy = null)
 * @method CdDrive[]    findAll()
 * @method CdDrive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CdDriveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CdDrive::class);
    }

    public function save(CdDrive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CdDrive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * @return CdDrive[]
     */
    public function findByCdd(array $criteria): array
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "(LOWER(cdd.name) LIKE :nameLike$key
                    OR LOWER(cdd.partNumber) LIKE :nameLike$key
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
                "SELECT cdd
                FROM App\Entity\CdDrive cdd JOIN cdd.manufacturer man LEFT OUTER JOIN cdd.storageDeviceAliases alias
                ORDER BY man.name ASC, cdd.name ASC"
            );
        }
        else{
            $query = $entityManager->createQuery(
                "SELECT cdd
                FROM App\Entity\CdDrive cdd JOIN cdd.manufacturer man LEFT OUTER JOIN cdd.storageDeviceAliases alias
                WHERE $whereString
                ORDER BY man.name ASC, cdd.name ASC"
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
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
