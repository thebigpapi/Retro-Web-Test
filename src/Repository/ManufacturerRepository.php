<?php

namespace App\Repository;

use App\Entity\Manufacturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Generator;

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

        $query = $entityManager->createNativeQuery(
            'SELECT distinct manufacturer.id, manufacturer.name, manufacturer.short_name, upper(coalesce(manufacturer.short_name, manufacturer.name)) as realname
            FROM motherboard_alias alias FULL OUTER JOIN motherboard mobo ON mobo.id=alias.motherboard_id, manufacturer
            WHERE manufacturer.id=coalesce(alias.manufacturer_id, mobo.manufacturer_id)
            ORDER BY realname;',
            $rsm
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

        $rsm = new ResultSetMapping();

       /* $query = $entityManager->createQuery(
            'SELECT DISTINCT man, COALESCE(man.name, man.short_name) realName
            FROM App\Entity\Chipset chip, App\Entity\Manufacturer man 
            WHERE chip.manufacturer=man 
            ORDER BY realName ASC'
        );*/

        $rsm->addEntityResult('App\Entity\Manufacturer', 'man');
        $rsm->addFieldResult('man', 'id', 'id');
        $rsm->addFieldResult('man', 'name', 'name');
        $rsm->addFieldResult('man', 'short_name', 'shortName');

        $query = $entityManager->createNativeQuery(
            'SELECT DISTINCT man.id, man.name, man.short_name, COALESCE(man.name, man.short_name) realName
            FROM chipset chip JOIN manufacturer man on chip.manufacturer_id=man.id 
            ORDER BY realName ASC',
            $rsm
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
     * @return array
     */
    public function findAllBiosManufacturer2(): array
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = 'SELECT COALESCE(m.short_name, m.name) as biosMan, COALESCE(m2.short_name, m2.name) as moboMan, mbmc.code from manufacturer m 
        JOIN manufacturer_bios_manufacturer_code mbmc on m.id = mbmc.bios_manufacturer_id
        JOIN manufacturer m2 on mbmc.manufacturer_id = m2.id
        ORDER BY biosMan, code;';
        $stmt = $conn->prepare($sql);
        $res = $stmt->executeQuery();

        $data = array();
        foreach ($res->fetchAllAssociative() as $row) {
            $data[$row["biosman"]][] = array($row["moboman"], $row["code"]);
        }

        return $data;
    }

    /**
     * @return array
     */
    public function findAllChipsetBiosManufacturer(): array
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = 'SELECT COALESCE(m.short_name, m.name) as chipsetMan, concat(c.part_no, concat(\' \', c.name)) as chipsetName, cbc.code from manufacturer m 
        JOIN chipset_bios_code cbc on m.id = cbc.bios_manufacturer_id
        JOIN chipset c on cbc.chipset_id = c.id
        ORDER BY chipsetMan, code;';
        $stmt = $conn->prepare($sql);
        $res = $stmt->executeQuery();

        $data = array();
        foreach ($res->fetchAllAssociative() as $row) {
            $data[$row["chipsetman"]][] = array($row["chipsetname"], $row["code"]);
        }

        return $data;
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
