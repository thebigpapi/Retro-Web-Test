<?php

namespace App\Repository;

use App\Entity\ExpansionChipBios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionChipBios>
 *
 * @method ExpansionChipBios|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionChipBios|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionChipBios[]    findAll()
 * @method ExpansionChipBios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionChipBiosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionChipBios::class);
    }
}
