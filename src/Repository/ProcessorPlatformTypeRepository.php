<?php

namespace App\Repository;

use App\Entity\ProcessorPlatformType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProcessorPlatformType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProcessorPlatformType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProcessorPlatformType[]    findAll()
 * @method ProcessorPlatformType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ProcessorPlatformType[]    findAllSorted()
 */
class ProcessorPlatformTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProcessorPlatformType::class);
    }

    /**
     * @return ProcessorPlatformType[] Returns an array of ProcessorPlatformType objects
     */
    public function findAllSorted()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT p
            FROM App\Entity\ProcessorPlatformType p
            ORDER BY p.name ASC"
        );
        return $query->getResult();
    }
}
