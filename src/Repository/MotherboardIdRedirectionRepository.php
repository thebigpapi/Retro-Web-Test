<?php

namespace App\Repository;

use App\Entity\MotherboardIdRedirection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method MotherboardIdRedirection|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardIdRedirection|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardIdRedirection[]    findAll()
 * @method MotherboardIdRedirection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardIdRedirectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardIdRedirection::class);
    }

    public function findRedirection(int $id, string $sourceType): ?int
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

    // /**
    //  * @return MotherboardIdRedirection[] Returns an array of MotherboardIdRedirection objects
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
    public function findOneBySomeField($value): ?MotherboardIdRedirection
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
