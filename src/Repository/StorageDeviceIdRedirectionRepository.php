<?php

namespace App\Repository;

use App\Entity\StorageDeviceIdRedirection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method StorageDeviceIdRedirection|null find($id, $lockMode = null, $lockVersion = null)
 * @method StorageDeviceIdRedirection|null findOneBy(array $criteria, array $orderBy = null)
 * @method StorageDeviceIdRedirection[]    findAll()
 * @method StorageDeviceIdRedirection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StorageDeviceIdRedirectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StorageDeviceIdRedirection::class);
    }

    public function findRedirection(int|string $identifier, string $sourceType): ?int
    {

        $entityManager = $this->getEntityManager();

        try {
            $query = $entityManager->createQuery(
                'SELECT max(redirection.destination)
                FROM App\Entity\StorageDeviceIdRedirection redirection
                WHERE :identifier=redirection.source AND :sourceType=redirection.sourceType'
            )->setParameter('sourceType', $sourceType)
            ->setParameter('identifier', $identifier);

            return $query->getSingleScalarResult();
        } catch (Exception $e) {
            return null;
        }
    }

    // /**
    //  * @return StorageDeviceIdRedirection[] Returns an array of StorageDeviceIdRedirection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StorageDeviceIdRedirection
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
