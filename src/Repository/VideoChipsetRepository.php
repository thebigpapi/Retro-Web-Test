<?php

namespace App\Repository;

use App\Entity\VideoChipset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoChipset|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoChipset|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoChipset[]    findAll()
 * @method VideoChipset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method VideoChipset[]    findAllVideoChipsetManufacturer()
 */
class VideoChipsetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoChipset::class);
    }

    /**
     * @return VideoChipset[]
     */
    public function findAllVideoChipsetManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT chip
            FROM App\Entity\VideoChipset chip, App\Entity\Manufacturer man 
            WHERE chip.manufacturer=man 
            ORDER BY man.name ASC, chip.name ASC'
        );

        return $query->getResult();
    }

    // /**
    //  * @return VideoChipset[] Returns an array of VideoChipset objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VideoChipset
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
