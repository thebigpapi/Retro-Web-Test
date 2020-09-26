<?php

namespace App\Repository;

use App\Entity\IoPort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method IoPort|null find($id, $lockMode = null, $lockVersion = null)
 * @method IoPort|null findOneBy(array $criteria, array $orderBy = null)
 * @method IoPort[]    findAll()
 * @method IoPort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IoPortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IoPort::class);
    }

    // /**
    //  * @return IoPort[] Returns an array of IoPort objects
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
    public function findOneBySomeField($value): ?IoPort
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
