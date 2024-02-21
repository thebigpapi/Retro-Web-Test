<?php

namespace App\Repository;

use App\Entity\Creditor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Creditor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creditor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creditor[]    findAll()
 * @method Creditor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creditor::class);
    }

    /**
     * @return Creditor[]
     */
    public function findAllCreditorsCaseInsensitiveSorted(array $criterias = []): array
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();

        $whereString = "";
        if (array_key_exists('name', $criterias)) {
            $whereString = "WHERE cre.name ILIKE :name";
        }

        $rsm->addEntityResult('App\Entity\Creditor', 'cre');
        $rsm->addFieldResult('cre', 'id', 'id');
        $rsm->addFieldResult('cre', 'name', 'name');
        $rsm->addFieldResult('cre', 'website', 'website');
        $rsm->addJoinedEntityResult('App\Entity\MotherboardImage', 'mi', 'cre', 'motherboardImages');
        $rsm->addFieldResult('mi', 'mi_id', 'id');
        $rsm->addJoinedEntityResult('App\Entity\ChipImage', 'ci', 'cre', 'chipImages');
        $rsm->addFieldResult('ci', 'ci_id', 'id');
        $rsm->addJoinedEntityResult('App\Entity\License', 'li', 'cre', 'license');
        $rsm->addFieldResult('li', 'li_id', 'id');
        $rsm->addFieldResult('li', 'li_name', 'name');

        $query = $entityManager->createNativeQuery(
            "SELECT cre.id, cre.name, cre.website, cre.license_id,
            mi.id as mi_id, ci.id as ci_id, li.id as li_id, li.name as li_name, upper(cre.name) as uppername
            FROM creditor cre
            LEFT JOIN motherboard_image mi ON cre.id=mi.creditor_id
            LEFT JOIN chip_image ci ON cre.id=ci.creditor_id
            LEFT JOIN license li ON cre.license_id=li.id
            $whereString 
            ORDER BY uppername;",
            $rsm
        );

        if (array_key_exists('name', $criterias)) {
            $query->setParameter(':name', '%' . $criterias['name'] . '%');
        }

        return $query->getResult();
    }

    // /**
    //  * @return Creditor[] Returns an array of Creditor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Creditor
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
