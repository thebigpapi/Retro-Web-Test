<?php

namespace App\Repository;

use App\Entity\MotherboardMemoryConnector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MotherboardMemoryConnector>
 *
 * @method MotherboardMemoryConnector|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardMemoryConnector|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardMemoryConnector[]    findAll()
 * @method MotherboardMemoryConnector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardMemoryConnectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardMemoryConnector::class);
    }

    public function save(MotherboardMemoryConnector $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MotherboardMemoryConnector $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MotherboardMemoryConnector[] Returns an array of MotherboardMemoryConnector objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MotherboardMemoryConnector
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
