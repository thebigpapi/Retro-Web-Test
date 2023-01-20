<?php

namespace App\Repository;

use App\Entity\ChipsetAlias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChipsetAlias|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChipsetAlias|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChipsetAlias[]    findAll()
 * @method ChipsetAlias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChipsetAliasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChipsetAlias::class);
    }
}
