<?php

namespace App\Repository;

use App\Entity\ChipsetDocumentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChipsetDocumentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChipsetDocumentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChipsetDocumentation[]    findAll()
 * @method ChipsetDocumentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChipsetDocumentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChipsetDocumentation::class);
    }
}
