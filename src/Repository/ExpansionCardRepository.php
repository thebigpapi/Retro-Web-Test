<?php

namespace App\Repository;

use App\Entity\ExpansionCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMapping;
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

    private function separateArraysFromValues(array $source, array &$arrays, array &$values): void
    {
        foreach ($source as $key => $val) {
            if (is_array($val)) {
                $arrays[$key] = json_decode(json_encode($val), true);
            } else {
                $values[$key] = $val;
            }
        }
    }

    private function ioPortsToSQL(array $ioPorts, array $from): array
    {
        foreach ($ioPorts as $key => $port) {
            if (isset($port['count'])) {
                $from[] = (count($from) == 0 ? " (" : " INTERSECT") . " SELECT ecip.expansion_card_id as id
                    FROM expansion_card_io_port ecip
                    WHERE ecip.io_port_interface_signal_id = :idPort" . $key . " AND (
                    (ecip.count=:portCount" . $key . " AND :signPort" . $key . "= '=') OR
                    (ecip.count>:portCount" . $key . " AND :signPort" . $key . "= '>') OR
                    (ecip.count<:portCount" . $key . " AND :signPort" . $key . "= '<') OR
                    (ecip.count<=:portCount" . $key . " AND :signPort" . $key . "= '<=') OR
                    (ecip.count>=:portCount" . $key . " AND :signPort" . $key . "= '>='))";
            } else {
                $from[] = (count($from) == 0 ? " (" : " INTERSECT") . " SELECT ec.id as id FROM expansion_card ec
                LEFT JOIN (SELECT *
                FROM expansion_card_io_port sub_ecip
                WHERE sub_ecip.io_port_interface_signal_id=:idPort$key ) as ecip ON ecip.expansion_card_id=ec.id
                WHERE io_port_interface_signal_id is NULL";
            }

        }

        return $from;
    }
    private function chipsToSQL(array $chips, array $from): array
    {
        foreach ($chips as $key => $chip) {
            $from[] = (count($from) == 0 ? " (" : " INTERSECT") . " SELECT ecexp.expansion_card_id as id
                    FROM expansion_card_chip ecexp
                    WHERE ecexp.chip_id=:idChip" . $key;
        }
        return $from;
    }
    private function dramTypesToSQL(array $dramTypes, array $from): array
    {
        foreach ($dramTypes as $key => $type) {
            $from[] = (count($from) == 0 ? " (" : " INTERSECT") . " SELECT ecdt.expansion_card_id as id
                FROM expansion_card_dram_type ecdt
                WHERE ecdt.dram_type_id=:idType" . $key;
        }
        return $from;
    }
    private function cardTypesToSQL(array $cardTypes, array $from): array
    {
        foreach ($cardTypes as $key => $type) {
            $from[] = (count($from) == 0 ? " (" : " INTERSECT") . " SELECT ect.expansion_card_id as id
                FROM expansion_card_expansion_card_type ect
                WHERE ect.expansion_card_type_id=:idCardType" . $key;
        }
        return $from;
    }

    private function valueToWhere(string $key, ?string $value): string //Warning ! Different behavior
    {
        return $key . "_id" . (is_null($value) ? " is NULL" : "=:$key");
    }

    private function valuesToWhere(array $values, array $where): array
    {
        foreach ($values as $key => $val) {
            $where[] = "expc." . $this->valueToWhere($key, $val);
        }
        return $where;
    }

    private function initResultSetMapping(): ResultSetMapping
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('App\Entity\ExpansionCard', 'expc');
        $rsm->addFieldResult('expc', 'id', 'id');
        $rsm->addFieldResult('expc', 'name', 'name');

        $rsm->addJoinedEntityResult('App\Entity\Manufacturer', 'man1', 'expc', 'manufacturer');
        $rsm->addFieldResult('man1', 'man1_id', 'id');
        $rsm->addFieldResult('man1', 'man1_name', 'name');

        return $rsm;
    }

    private function prepareQuery(array $values, array $arrays): string
    {
        // Gathering name, manufacturer, sockets and platforms which are handled differently compared to other values
        if (array_key_exists('name', $values)) {
            $name = $values['name'];
            unset($values['name']);
        }
        if (array_key_exists('manufacturer', $values)) {
            $manufacturer = $values['manufacturer'];
            unset($values['manufacturer']);
        }
        if (array_key_exists('type', $values)) {
            $type = $values['type'];
            unset($values['type']);
        }
        if (array_key_exists('cardExpansionSlot', $values)) {
            $slot = $values['cardExpansionSlot'];
            unset($values['cardExpansionSlot']);
        }

        // Creating interesct statements
        $from = array();


            if (array_key_exists("expansionSlots", $arrays)) {
                $from = $this->expansionSlotsToSQL($arrays['expansionSlots'], $from);
            }
            if (array_key_exists("cardIoPorts", $arrays)) {
                $from = $this->ioPortsToSQL($arrays['cardIoPorts'], $from);
            }
            if (array_key_exists("chips", $arrays)) {
                $from = $this->chipsToSQL($arrays['chips'], $from);
            }
            if (array_key_exists("dramTypes", $arrays)) {
                $from = $this->dramTypesToSQL($arrays['dramTypes'], $from);
            }
            if (array_key_exists("cardTypes", $arrays)) {
                $from = $this->cardTypesToSQL($arrays['cardTypes'], $from);
            }


        // Creating where statements
        $where = $this->valuesToWhere($values, array());

        // Searching name and manufacturer into actual expansion card name and alias
        if (isset($name)) {
            if (array_key_exists('manufacturer', get_defined_vars())) {
                if (is_null($manufacturer)) {
                    $where[] = "((expc.name ILIKE :name AND expc.manufacturer_id IS NULL) OR expc.id IN
                    (SELECT expansion_card_id FROM expansion_card_alias AS eca
                    WHERE eca.name ILIKE :name AND eca.manufacturer_id IS NULL)) ";
                } else {
                    $where[] = "((expc.name ILIKE :name AND expc.manufacturer_id = :manufacturer) OR expc.id IN
                    (SELECT expansion_card_id FROM expansion_card_alias AS eca
                    WHERE eca.name ILIKE :name AND eca.manufacturer_id = :manufacturer)) ";
                }
            } else {
                $where[] = "((expc.name ILIKE :name) OR expc.id IN
                (SELECT expansion_card_id FROM expansion_card_alias AS eca WHERE eca.name ILIKE :name)) ";
            }
        } elseif (array_key_exists('manufacturer', get_defined_vars())) {
            if (is_null($manufacturer)) {
                $where[] = "( expc.manufacturer_id IS NULL OR expc.id IN
                (SELECT expansion_card_id FROM expansion_card_alias AS eca WHERE eca.manufacturer_id IS NULL)) ";
            } else {
                $where[] = "( expc.manufacturer_id = :manufacturer OR expc.id IN
                (SELECT expansion_card_id FROM expansion_card_alias AS eca WHERE eca.manufacturer_id = :manufacturer)) ";
            }
        }
        if (isset($slot)) {
            $where[] = " expc.expansion_slot_interface_signal_id = :cardExpansionSlot";
        }

        // Turning from and where arrays to SQL statements
        $fromSql = !empty($from) ? "JOIN " . implode(" ", $from) . ") as io_slot_chip ON expc.id=io_slot_chip.id" : "";
        $whereSQL = (!empty($where)) ? " WHERE " .implode(" AND ", $where) : "";
        //dd($from);
        // Building SQL query
        $sql = "
            SELECT expc.*, man1.id as man1_id, man1.name as man1_name FROM expansion_card expc
            LEFT JOIN manufacturer man1 ON expc.manufacturer_id = man1.id
            $fromSql
            $whereSQL ORDER BY man1_name ASC, expc.name ASC LIMIT 10000";
        return $sql;
    }

    private function setQueryParameters(NativeQuery &$query, array $values, array $arrays): void
    {

        if (array_key_exists("cardIoPorts", $arrays)) {
            foreach ($arrays['cardIoPorts'] as $key => $val) {
                $query->setParameter("idPort" . $key, $val['id']);
                $query->setParameter("signPort" . $key, $val['sign']);
                if (array_key_exists("count", $val)) {
                    $query->setParameter("portCount" . $key, $val['count']);
                }
            }
        }

        if (array_key_exists("chips", $arrays)) {
            foreach ($arrays['chips'] as $key => $val) {
                $query->setParameter("idChip" . $key, $val);
            }
        }
        if (array_key_exists("dramTypes", $arrays)) {
            foreach ($arrays['dramTypes'] as $key => $val) {
                $query->setParameter("idType" . $key, $val);
            }
        }
        if (array_key_exists("cardTypes", $arrays)) {
            foreach ($arrays['cardTypes'] as $key => $val) {
                $query->setParameter("idCardType" . $key, $val);
            }
        }

        // setting the rest of the parameters
        foreach ($values as $key => $val) {
            if ($val != null) {
                if ($key !== "name") {
                    $query->setParameter($key, $val);
                } else {
                    $query->setParameter($key, "%$val%");
                }
            }
        }
        //dd($values);
    }

    /**
     * @return ExpansionCard[] Returns an array of ExpansionCard objects
     */
    public function findByWithJoin(array $criteria)
    {
        $arrays = array();
        $values = array();
        //dd($criteria);
        if($criteria == [])
            return [];
        $this->separateArraysFromValues($criteria, $arrays, $values);

        $sql = $this->prepareQuery($values, $arrays);

        $rsm = $this->initResultSetMapping();

        $em = $this->getEntityManager();
        $query = $em->createNativeQuery($sql, $rsm);

        $this->setQueryParameters($query, $values, $arrays);

        return $query->setCacheable(true)
            ->getResult();
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
        if (array_key_exists('chips', $criteria)) {
            foreach ($criteria['chips'] as $key => $value) {
                $whereArray[] = "(card.id in (select m$key.id from App\Entity\ExpansionCard m$key JOIN m$key.chips ec$key where ec$key.id=:idChip$key))";
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
