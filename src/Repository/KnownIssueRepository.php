<?php

namespace App\Repository;

use App\Entity\Enum\KnownIssueType;
use App\Entity\KnownIssue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KnownIssue|null find($id, $lockMode = null, $lockVersion = null)
 * @method KnownIssue|null findOneBy(array $criteria, array $orderBy = null)
 * @method KnownIssue[]    findAll()
 * @method KnownIssue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KnownIssueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KnownIssue::class);
    }

    /**
     * @return KnownIssue[] Returns an array of KnownIssue objects
     */
    public function findAllByType(KnownIssueType $type)
    {
        return $this->createQueryBuilder('k')
            //->andWhere('k.type = :val')
            ->andWhere('BIT_AND(k.type, :val) > 0')
            ->setParameter('val', $type->value)
            ->orderBy('k.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
