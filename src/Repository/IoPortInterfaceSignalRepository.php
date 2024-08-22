<?php

namespace App\Repository;

use App\Entity\IoPortInterfaceSignal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IoPortInterfaceSignal>
 *
 * @method IoPortInterfaceSignal|null find($id, $lockMode = null, $lockVersion = null)
 * @method IoPortInterfaceSignal|null findOneBy(array $criteria, array $orderBy = null)
 * @method IoPortInterfaceSignal[]    findAll()
 * @method IoPortInterfaceSignal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IoPortInterfaceSignalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IoPortInterfaceSignal::class);
    }
    public function getCount(): int
    {
        return $this->createQueryBuilder('ip')
            ->select('count(ip.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function findAllSorted(): array
    {
        return $this->createQueryBuilder('ip')
            ->orderBy('ip.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
