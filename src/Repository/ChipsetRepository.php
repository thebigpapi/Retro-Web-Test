<?php

namespace App\Repository;

use App\Entity\Chipset;
use App\Entity\Manufacturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Chipset|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chipset|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chipset[]    findAll()
 * @method Chipset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChipsetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chipset::class);
    }

    /**
     * @return Chipset[]
     */
    public function findAllChipsetManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT chip
            FROM App\Entity\Chipset chip, App\Entity\Manufacturer man 
            WHERE chip.manufacturer=man 
            ORDER BY man.name ASC, chip.name ASC'
        );

        return $query->getResult();
    }


    /**
     * @return Chipset[]
     */
    public function findByManufacturer(Manufacturer $man)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.manufacturer = :man')
            ->setParameter('man', $man)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Chipset[]
     */
    public function findAllMotherboardChipset(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT chip
            FROM App\Entity\Chipset chip, App\Entity\Motherboard mobo 
            WHERE mobo.chipset=chip'
        );

        return $query->getResult();
    }

    // /**
    //  * @return Chipset[] Returns an array of Chipset objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Chipset
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
