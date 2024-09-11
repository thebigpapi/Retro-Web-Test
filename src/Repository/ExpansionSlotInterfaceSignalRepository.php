<?php

namespace App\Repository;

use App\Entity\ExpansionSlotInterfaceSignal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionSlotInterfaceSignal>
 *
 * @method ExpansionSlotInterfaceSignal|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionSlotInterfaceSignal|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionSlotInterfaceSignal[]    findAll()
 * @method ExpansionSlotInterfaceSignal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionSlotInterfaceSignalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionSlotInterfaceSignal::class);
    }

    /**
     * @return ExpansionSlotInterfaceSignal[]
     */
    public function findByExpansionSlot(array $criteria): array
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "LOWER(es.name) LIKE :nameLike$key";
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
                "SELECT es
                FROM App\Entity\ExpansionSlotInterfaceSignal es
                WHERE $whereString
                ORDER BY es.name ASC"
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
        return $this->createQueryBuilder('es')
            ->select('count(es.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllSorted(): array
    {
        return $this->createQueryBuilder('es')
            ->orderBy('es.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
