<?php

namespace App\Repository;

use App\Entity\CpuSocket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CpuSocket|null find($id, $lockMode = null, $lockVersion = null)
 * @method CpuSocket|null findOneBy(array $criteria, array $orderBy = null)
 * @method CpuSocket[]    findAll()
 * @method CpuSocket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CpuSocketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CpuSocket::class);
    }

    public function getCount(): int
    {
        return $this->createQueryBuilder('sk')
            ->select('count(sk.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllSorted(): array
    {
        return $this->createQueryBuilder('sk')
            ->orderBy('sk.name', 'ASC')
            ->orderBy('sk.type', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
