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
    public function findSlug(string $slug): ExpansionCard|null
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT card
            FROM App\Entity\ExpansionCard card
            WHERE card.slug = :slug"
        )->setParameter('slug', $slug);

        return $query->getOneOrNullResult();
    }

    public function checkIdentifierExists(string|int $identifier): bool
    {
        $entityManager = $this->getEntityManager();

        if (is_int($identifier) && is_numeric($identifier)) {
            $query = $entityManager->createQuery(
                'SELECT card
                FROM App\Entity\ExpansionCard card
                WHERE card.id=:identifier'
            )->setParameter('identifier', $identifier);
        } else {
            $query = $entityManager->createQuery(
                'SELECT card
                FROM App\Entity\ExpansionCard card
                WHERE card.slug=:identifier'
            )->setParameter('identifier', $identifier);
        }

        return boolval(count($query->getResult()));
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
            $whereArray[] = "(man.id = :manufacturerId OR alias.manufacturer = :manufacturerId)";
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
    public function findLatest(int $maxCount = 12)
    {
        return $this->createQueryBuilder('ec')
            ->orderBy('ec.lastEdited', 'DESC')
            ->setMaxResults($maxCount)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return ExpansionCard[]
     */
    public function findAllByCreditor(int $cid): array
    {
        $entityManager = $this->getEntityManager();
        $dql   = "SELECT DISTINCT ec
        FROM App:ExpansionCard ec
        JOIN ec.images eci LEFT JOIN eci.creditor c
        WHERE c.id = :cid
        ORDER BY ec.name ASC";
        $query = $entityManager->createQuery($dql)->setParameter(":cid", $cid);
        return $query->getResult();
    }
}
