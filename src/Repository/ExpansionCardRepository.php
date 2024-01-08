<?php

namespace App\Repository;

use App\Entity\ExpansionCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionCard>
 *
 * @method ExpansionCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionCard[]    findAll()
 * @method ExpansionCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionCard::class);
    }

//    /**
//     * @return ExpansionCard[] Returns an array of ExpansionCard objects
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

//    public function findOneBySomeField($value): ?ExpansionCard
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
