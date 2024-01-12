<?php

namespace App\Repository;

use App\Entity\IoPortInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IoPortInterface>
 *
 * @method IoPortInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method IoPortInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method IoPortInterface[]    findAll()
 * @method IoPortInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IoPortInterfaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IoPortInterface::class);
    }

//    /**
//     * @return IoPortInterface[] Returns an array of IoPortInterface objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?IoPortInterface
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
