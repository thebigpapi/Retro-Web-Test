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

    public function findMotherboardRedirection(int $id, string $sourceType):?int {

        $entityManager = $this->getEntityManager();

        try {        
            $query = $entityManager->createQuery(
                'SELECT max(redirection.destination)
                FROM App\Entity\MotherboardIdRedirection redirection
                WHERE :id=redirection.source AND :sourceType=redirection.sourceType'
            )->setParameter('sourceType', $sourceType)
            ->setParameter('id', $id);

            return $query->getSingleScalarResult();
        }
        catch (Exception $e)
        {
            return null;
        }
        
    }

    // /**
    //  * @return IdRedirection[] Returns an array of IdRedirection objects
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
    public function findOneBySomeField($value): ?IdRedirection
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
