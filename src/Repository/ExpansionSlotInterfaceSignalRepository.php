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
    public function getCount(): int
    {
        return $this->createQueryBuilder('es')
            ->select('count(es.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
