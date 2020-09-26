<?php

namespace App\Repository;

use App\Entity\Manufacturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Manufacturer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manufacturer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manufacturer[]    findAll()
 * @method Manufacturer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Manufacturer[]    findAllMotherboardManufacturer()
 */
class ManufacturerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manufacturer::class);
    }

    /**
     * @return Manufacturer[]
     */
    public function findAllMotherboardManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT man
            FROM App\Entity\Motherboard mobo, App\Entity\Manufacturer man 
            WHERE mobo.manufacturer=man
            ORDER BY man.name ASC'
        );

        
        return $query->getResult();
    }

    /**
     * @return Manufacturer[]
     */
    public function findAllChipsetManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT man
            FROM App\Entity\Chipset chip, App\Entity\Manufacturer man 
            WHERE chip.manufacturer=man 
            ORDER BY man.name ASC'
        );

        return $query->getResult();
    }

    /**
     * @return Manufacturer[]
     */
    public function findAllBiosManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT man
            FROM App\Entity\MotherboardBios bios, App\Entity\Manufacturer man 
            WHERE bios.manufacturer=man 
            ORDER BY man.name ASC'
        );

        return $query->getResult();
    }

    // /**
    //  * @return Manufacturer[] Returns an array of Manufacturer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Manufacturer
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
