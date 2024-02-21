<?php

namespace App\Repository;

use App\Entity\LargeFileExpansionCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LargeFileExpansionCard>
 *
 * @method LargeFileExpansionCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method LargeFileExpansionCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method LargeFileExpansionCard[]    findAll()
 * @method LargeFileExpansionCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LargeFileExpansionCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LargeFileExpansionCard::class);
    }

//    /**
//     * @return LargeFileExpansionCard[] Returns an array of LargeFileExpansionCard objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LargeFileExpansionCard
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
