<?php

namespace App\Repository;

use App\Entity\ExpansionCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionCard>
 *
 * @method ExpansionCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionCard[]    findAll()
 * @method ExpansionCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionCard::class);
    }
    /**
     * @return ExpansionCard[]
     */
    public function findByExpansionCard(array $criteria): array
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "(LOWER(card.name) LIKE :nameLike$key 
                    OR LOWER(alias.name) LIKE :nameLike$key)";
                $valuesArray["nameLike$key"] = "%" . strtolower($val) . "%";
            }
        }
        if (array_key_exists('expansionChips', $criteria)) {
            foreach ($criteria['expansionChips'] as $key => $value) {
                $whereArray[] = "(card.id in (select m$key.id from App\Entity\ExpansionCard m$key JOIN m$key.expansionChips ec$key where ec$key.id=:idChip$key))";
                $valuesArray["idChip$key"] = $value;
            }
        }
        if (array_key_exists('manufacturer', $criteria)) {
            $whereArray[] = "(man.id = :manufacturerId)";
            $valuesArray["manufacturerId"] = (int)$criteria['manufacturer'];
        }
        if (array_key_exists('type', $criteria)) {
            $whereArray[] = "(typ.id = :typeId)";
            $valuesArray["typeId"] = (int)$criteria['type'];
        }

        // Building where statement
        $whereString = implode(" AND ", $whereArray);

        // Building query
        if($whereArray == []){
            return [];
        }
        else{
            $query = $entityManager->createQuery(
                "SELECT card
                FROM App\Entity\ExpansionCard card JOIN card.manufacturer man LEFT OUTER JOIN card.expansionCardAliases alias LEFT JOIN card.type typ
                WHERE $whereString
                ORDER BY man.name ASC, card.name ASC"
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
        return $this->createQueryBuilder('ec')
            ->select('count(ec.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
