<?php

namespace App\Repository;

use App\Entity\ExpansionSlotInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionSlotInterface>
 *
 * @method ExpansionSlotInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionSlotInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionSlotInterface[]    findAll()
 * @method ExpansionSlotInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionSlotInterfaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionSlotInterface::class);
    }

//    /**
//     * @return ExpansionSlotInterface[] Returns an array of ExpansionSlotInterface objects
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

//    public function findOneBySomeField($value): ?ExpansionSlotInterface
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
