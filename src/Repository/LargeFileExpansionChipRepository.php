<?php

namespace App\Repository;

use App\Entity\LargeFileExpansionChip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LargeFileExpansionChip|null find($id, $lockMode = null, $lockVersion = null)
 * @method LargeFileExpansionChip|null findOneBy(array $criteria, array $orderBy = null)
 * @method LargeFileExpansionChip[]    findAll()
 * @method LargeFileExpansionChip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LargeFileExpansionChipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LargeFileExpansionChip::class);
    }
}
