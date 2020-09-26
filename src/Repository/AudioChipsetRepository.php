<?php

namespace App\Repository;

use App\Entity\AudioChipset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AudioChipset|null find($id, $lockMode = null, $lockVersion = null)
 * @method AudioChipset|null findOneBy(array $criteria, array $orderBy = null)
 * @method AudioChipset[]    findAll()
 * @method AudioChipset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method AudioChipset[]    findAllAudioChipsetManufacturer()
 */
class AudioChipsetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AudioChipset::class);
    }

    /**
     * @return AudioChipset[]
     */
    public function findAllAudioChipsetManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT chip
            FROM App\Entity\AudioChipset chip, App\Entity\Manufacturer man 
            WHERE chip.manufacturer=man 
            ORDER BY man.name ASC, chip.name ASC'
        );

        return $query->getResult();
    }

    // /**
    //  * @return AudioChipset[] Returns an array of AudioChipset objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AudioChipset
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
