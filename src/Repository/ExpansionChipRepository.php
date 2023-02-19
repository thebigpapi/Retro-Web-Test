<?php

namespace App\Repository;

use App\Entity\ExpansionChip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExpansionChip|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionChip|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionChip[]    findAll()
 * @method ExpansionChip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ExpansionChip[]    findAllExpansionChipManufacturer()
 */
class ExpansionChipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionChip::class);
    }

    /**
     * @return ExpansionChip[]
     */
    public function findAllExpansionChipManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT chip
            FROM App\Entity\ExpansionChip chip, App\Entity\Manufacturer man 
            WHERE chip.manufacturer=man 
            ORDER BY man.name ASC, chip.name ASC'
        );

        return $query->getResult();
    }

    /**
     * @return ExpansionChip[]
     */
    public function findAllExpansionChipsAdminList(array $criterias = []): array
    {
        $entityManager = $this->getEntityManager();

        $where = [];
        $valuesArray = [];
        if (array_key_exists('manufacturer', $criterias)) {
            $valuesArray['manId'] = $criterias['manufacturer'];
            $where[] = "man.id=:manId";
        }
        if (array_key_exists('type', $criterias)) {
            $valuesArray['typeId'] = $criterias['type'];
            $where[] = "typ.id=:typeId";
        }

        // Building where statement
        $andWhere = implode(' AND ', $where);

        // Building query
        $query = $entityManager->createQuery(
            "SELECT chip, man, pd, img, drv, typ, doc
            FROM App\Entity\ExpansionChip chip
            JOIN chip.manufacturer man 
            LEFT JOIN chip.pciDevs pd
            LEFT JOIN chip.images img
            LEFT JOIN chip.drivers drv
            LEFT JOIN chip.documentations doc
            JOIN chip.type typ
            $andWhere
            ORDER BY man.name ASC, chip.name ASC"
        );
        if (array_key_exists('manufacturer', $criterias)) {
            $query->
            $where[] = "man.id=:manId";
        }

        // Setting values
        foreach ($valuesArray as $key => $value) {
            $query->setParameter($key, $value);
        }


        return $query->getResult();
    }

    // /**
    //  * @return ExpansionChip[] Returns an array of ExpansionChip objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExpansionChip
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
