<?php

namespace App\Repository;

use App\Entity\ExpansionCardMemoryConnector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionCardMemoryConnector>
 *
 * @method ExpansionCardMemoryConnector|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionCardMemoryConnector|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionCardMemoryConnector[]    findAll()
 * @method ExpansionCardMemoryConnector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionCardMemoryConnectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionCardMemoryConnector::class);
    }

//    /**
//     * @return ExpansionCardMemoryConnector[] Returns an array of ExpansionCardMemoryConnector objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExpansionCardMemoryConnector
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
