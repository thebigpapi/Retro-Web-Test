<?php

namespace App\Repository;

use App\Entity\ChipDocumentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChipDocumentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChipDocumentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChipDocumentation[]    findAll()
 * @method ChipDocumentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChipDocumentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChipDocumentation::class);
    }
}
