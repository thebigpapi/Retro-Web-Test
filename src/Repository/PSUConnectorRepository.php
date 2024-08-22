<?php

namespace App\Repository;

use App\Entity\PSUConnector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PSUConnector|null find($id, $lockMode = null, $lockVersion = null)
 * @method PSUConnector|null findOneBy(array $criteria, array $orderBy = null)
 * @method PSUConnector[]    findAll()
 * @method PSUConnector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PSUConnectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PSUConnector::class);
    }

    public function getCount(): int
    {
        return $this->createQueryBuilder('pw')
            ->select('count(pw.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllSorted(): array
    {
        return $this->createQueryBuilder('pw')
            ->orderBy('pw.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
