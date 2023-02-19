<?php

namespace App\Repository;

use App\Entity\IdRedirection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method IdRedirection|null find($id, $lockMode = null, $lockVersion = null)
 * @method IdRedirection|null findOneBy(array $criteria, array $orderBy = null)
 * @method IdRedirection[]    findAll()
 * @method IdRedirection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdRedirectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IdRedirection::class);
    }

    public function findMotherboardRedirection(int $id, string $sourceType): ?int
    {

        $entityManager = $this->getEntityManager();

        try {
            $query = $entityManager->createQuery(
                'SELECT max(redirection.destination)
                FROM App\Entity\MotherboardIdRedirection redirection
                WHERE :id=redirection.source AND :sourceType=redirection.sourceType'
            )->setParameter('sourceType', $sourceType)
                ->setParameter('id', $id);

            return $query->getSingleScalarResult();
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Check if the redirection exists for $identifier for a given motherboard
     */
    public function checkRedirectionExists(int|string $identifier, string $sourceType, ?int $motherboardId = null): bool
    {
        $entityManager = $this->getEntityManager();

        $andWhere = "";
        if ($motherboardId !== null) {
            $andWhere = " AND NOT redirection.destination=:motherboardId ";
        }

        $query = $entityManager->createQuery(
            'SELECT redirection
            FROM App\Entity\MotherboardIdRedirection redirection
            WHERE redirection.sourceType=:sourceType AND redirection.source=:identifier  ' . $andWhere
        )->setParameter('identifier', $identifier)
            ->setParameter('sourceType', $sourceType);

        if ($motherboardId !== null) {
            $query->setParameter('motherboardId', $motherboardId);
        }

        return boolval(count($query->getResult()));
    }
}
