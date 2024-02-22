<?php

namespace App\Repository;

use App\Entity\ExpansionCardPowerConnector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionCardPowerConnector>
 *
 * @method ExpansionCardPowerConnector|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionCardPowerConnector|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionCardPowerConnector[]    findAll()
 * @method ExpansionCardPowerConnector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionCardPowerConnectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionCardPowerConnector::class);
    }

//    /**
//     * @return ExpansionCardPowerConnector[] Returns an array of ExpansionCardPowerConnector objects
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

//    public function findOneBySomeField($value): ?ExpansionCardPowerConnector
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
