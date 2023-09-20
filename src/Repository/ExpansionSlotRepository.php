<?php

namespace App\Repository;

use App\Entity\ExpansionSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExpansionSlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionSlot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionSlot[]    findAll()
 * @method ExpansionSlot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ExpansionSlot[]    findByPopularity()
 */
class ExpansionSlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionSlot::class);
    }

    /**
    * @return ExpansionSlot[] Returns an array of ExpansionSlot objects
    */
    public function findByPopularity()
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\ExpansionSlot', 'es');
        $rsm->addJoinedEntityResult('App\Entity\MotherboardExpansionSlot', 'mes', 'es', 'motherboardExpansionSlots');
        $rsm->addFieldResult('es', 'id', 'id');
        $rsm->addFieldResult('es', 'name', 'name');

        $query = $entityManager->createNativeQuery(
            "SELECT es.id, count(mes.expansion_slot_id) as popularity, es.name
            FROM expansion_slot es JOIN motherboard_expansion_slot mes ON es.id=mes.expansion_slot_id GROUP BY es.id, es.name
            ORDER BY popularity DESC;",
            $rsm
        );
        return $query->getResult();
    }
}
