<?php

namespace App\Repository;

use App\Entity\ExpansionCardAlias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionCardAlias>
 *
 * @method ExpansionCardAlias|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionCardAlias|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionCardAlias[]    findAll()
 * @method ExpansionCardAlias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionCardAliasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionCardAlias::class);
    }

//    /**
//     * @return ExpansionCardAlias[] Returns an array of ExpansionCardAlias objects
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

//    public function findOneBySomeField($value): ?ExpansionCardAlias
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
