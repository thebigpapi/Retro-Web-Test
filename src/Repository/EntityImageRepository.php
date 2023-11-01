<?php

namespace App\Repository;

use App\Entity\EntityImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EntityImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityImage[]    findAll()
 * @method EntityImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityImage::class);
    }
}
