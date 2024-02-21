<?php

namespace App\Repository;

use App\Entity\LargeFileChipsetPart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LargeFileChipsetPart>
 *
 * @method LargeFileChipsetPart|null find($id, $lockMode = null, $lockVersion = null)
 * @method LargeFileChipsetPart|null findOneBy(array $criteria, array $orderBy = null)
 * @method LargeFileChipsetPart[]    findAll()
 * @method LargeFileChipsetPart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LargeFileChipsetPartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LargeFileChipsetPart::class);
    }

    public function save(LargeFileChipsetPart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LargeFileChipsetPart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LargeFileChipsetPart[] Returns an array of LargeFileChipsetPart objects
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

//    public function findOneBySomeField($value): ?LargeFileChipsetPart
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
