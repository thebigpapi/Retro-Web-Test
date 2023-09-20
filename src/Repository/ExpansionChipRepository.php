<?php

namespace App\Repository;

use App\Entity\ExpansionChip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExpansionChip|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionChip|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionChip[]    findAll()
 * @method ExpansionChip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ExpansionChip[]    findAllExpansionChipManufacturer()
 * @method ExpansionChip[]    findByPopularity()
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
    public function findByPopularity()
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\ExpansionChip', 'ec');
        $rsm->addJoinedEntityResult('App\Entity\Manufacturer', 'man', 'ec', 'manufacturer');
        $rsm->addFieldResult('ec', 'id', 'id');
        $rsm->addFieldResult('ec', 'name', 'name');
        $rsm->addFieldResult('ec', 'part_number', 'partNumber');
        $rsm->addFieldResult('man', 'man_id', 'id');
        $rsm->addFieldResult('man', 'man_name', 'name');

        $query = $entityManager->createNativeQuery(
            "SELECT ec.id, count(moboec.expansion_chip_id) as popularity, man.id as man_id, man.name as man_name, ch.name, ch.part_number
            FROM expansion_chip ec JOIN chip ch ON ch.id=ec.id JOIN manufacturer man ON ch.manufacturer_id=man.id JOIN motherboard_expansion_chip moboec ON ec.id=moboec.expansion_chip_id 
            GROUP BY ec.id, man_id, man_name, ch.name, ch.part_number
            ORDER BY popularity DESC;",
            $rsm
        );
        return $query->getResult();
    }
}
