<?php

namespace App\Repository;

use App\Entity\ExpansionCardIdRedirection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method ExpansionCardIdRedirection|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionCardIdRedirection|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionCardIdRedirection[]    findAll()
 * @method ExpansionCardIdRedirection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionCardIdRedirectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionCardIdRedirection::class);
    }

    public function findRedirection(int|string $identifier, string $sourceType): ?int
    {

        $entityManager = $this->getEntityManager();

        try {
            $query = $entityManager->createQuery(
                'SELECT max(redirection.destination)
                FROM App\Entity\ExpansionCardIdRedirection redirection
                WHERE :identifier=redirection.source AND :sourceType=redirection.sourceType'
            )->setParameter('sourceType', $sourceType)
            ->setParameter('identifier', $identifier);

            return $query->getSingleScalarResult();
        } catch (Exception $e) {
            return null;
        }
    }
}
