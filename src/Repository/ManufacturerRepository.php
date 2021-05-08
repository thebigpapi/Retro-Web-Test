<?php

namespace App\Repository;

use App\Entity\Manufacturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

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

        $rsm = new ResultSetMapping();
        

        $rsm->addEntityResult('App\Entity\Manufacturer', 'man');
        $rsm->addFieldResult('man', 'id', 'id');
        $rsm->addFieldResult('man', 'name', 'name');
        $rsm->addFieldResult('man', 'short_name', 'shortName');

        $query = $entityManager->createNativeQuery('SELECT DISTINCT manufacturer.id, manufacturer.name, manufacturer.short_name  
        FROM motherboard_alias alias FULL OUTER JOIN motherboard mobo ON mobo.manufacturer_id=alias.manufacturer_id, manufacturer 
        WHERE manufacturer.id=coalesce(alias.manufacturer_id,mobo.manufacturer_id) 
        ORDER BY manufacturer.name;', $rsm
        );
        
        return $query->setCacheable(true)
        ->getResult();
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

    /**
     * @return Manufacturer[]
     */
    public function findAllProcessorManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT man
            FROM App\Entity\Processor p, App\Entity\Manufacturer man 
            WHERE p.manufacturer=man 
            ORDER BY man.name ASC'
        );

        return $query->getResult();
    }

    /**
     * @return Manufacturer[]
     */
    public function findAllAudioChipManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT man
            FROM App\Entity\AudioChipset ac, App\Entity\Manufacturer man 
            WHERE ac.manufacturer=man 
            ORDER BY man.name ASC'
        );

        return $query->getResult();
    }

    /**
     * @return Manufacturer[]
     */
    public function findAllVideoChipManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT man
            FROM App\Entity\VideoChipset vc, App\Entity\Manufacturer man 
            WHERE vc.manufacturer=man 
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
