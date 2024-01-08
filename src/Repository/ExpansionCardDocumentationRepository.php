<?php

namespace App\Repository;

use App\Entity\ExpansionCardDocumentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionCardDocumentation>
 *
 * @method ExpansionCardDocumentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionCardDocumentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionCardDocumentation[]    findAll()
 * @method ExpansionCardDocumentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionCardDocumentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionCardDocumentation::class);
    }

//    /**
//     * @return ExpansionCardDocumentation[] Returns an array of ExpansionCardDocumentation objects
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

//    public function findOneBySomeField($value): ?ExpansionCardDocumentation
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
