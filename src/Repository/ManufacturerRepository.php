<?php

namespace App\Repository;

use App\Entity\Manufacturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Generator;
use Symfony\Component\Clock\NativeClock;

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
    public function findByManufacturer(array $criteria): array
    {
        $entityManager = $this->getEntityManager();

        $whereArray = array();
        $valuesArray = array();

        // Checking values in criteria and creating WHERE statements
        if (array_key_exists('name', $criteria)) {
            $multicrit = explode(" ", $criteria['name']);
            foreach ($multicrit as $key => $val) {
                $whereArray[] = "(LOWER(man.name) LIKE :nameLike$key
                    OR LOWER(man.fullName) LIKE :nameLike$key)";
                $valuesArray["nameLike$key"] = "%" . strtolower($val) . "%";
            }
        }

        // Building where statement
        $whereString = implode(" AND ", $whereArray);

        // Building query
        if($whereArray == []){
            return [];
        }
        else{
            $query = $entityManager->createQuery(
                "SELECT man
                FROM App\Entity\Manufacturer man
                WHERE $whereString
                ORDER BY man.name ASC, man.fullName ASC"
            );
        }
        // Setting values
        foreach ($valuesArray as $key => $value) {
            $query->setParameter($key, $value);
        }
        return $query->getResult();
    }

    public function getCount(): int
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Manufacturer[]
     */
    public function findAllManufacturerCaseInsensitiveSorted(array $criterias = []): array
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();

        $whereString = "";
        if (array_key_exists('name', $criterias)) {
            $whereString = "WHERE realname ILIKE :name";
        }

        $rsm->addEntityResult('App\Entity\Manufacturer', 'man');
        $rsm->addFieldResult('man', 'id', 'id');
        $rsm->addFieldResult('man', 'name', 'name');
        $rsm->addFieldResult('man', 'fccid', 'fccid');
        $rsm->addJoinedEntityResult('App\Entity\PciVendorId', 'pv', 'man', 'pciVendorIds');
        $rsm->addFieldResult('pv', 'pvid', 'id');
        $rsm->addFieldResult('pv', 'ven', 'ven');

        $query = $entityManager->createNativeQuery(
            "SELECT * FROM (SELECT distinct man.id, man.name, man.fccid, pv.id as pvid, pv.ven
            FROM manufacturer man LEFT JOIN pci_vendor_id pv ON pv.manufacturer_id=man.id) as req
            $whereString 
            ORDER BY man.name;",
            $rsm
        );

        if (array_key_exists('name', $criterias)) {
            $query->setParameter(':name', '%' . $criterias['name'] . '%');
        }

        return $query->getResult();
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

        $query = $entityManager->createNativeQuery(
            'SELECT distinct man.id, man.name
            FROM (SELECT distinct man.* FROM manufacturer man JOIN motherboard mobo ON mobo.manufacturer_id = man.id
            UNION SELECT distinct man.* FROM manufacturer man JOIN motherboard_alias alias ON alias.manufacturer_id = man.id) as man
            ORDER BY man.name;',
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

        $rsm->addEntityResult('App\Entity\Manufacturer', 'man');
        $rsm->addFieldResult('man', 'id', 'id');
        $rsm->addFieldResult('man', 'name', 'name');

        $query = $entityManager->createNativeQuery(
            'SELECT DISTINCT man.id, man.name
            FROM chipset chip JOIN manufacturer man on chip.manufacturer_id=man.id
            ORDER BY man.name ASC',
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

        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('App\Entity\Manufacturer', 'man');
        $rsm->addFieldResult('man', 'id', 'id');
        $rsm->addFieldResult('man', 'name', 'name');

        $query = $entityManager->createNativeQuery(
            'SELECT distinct man.id, man.name
            FROM (SELECT distinct man.* FROM manufacturer man JOIN motherboard_bios bios ON bios.manufacturer_id = man.id) as man
            ORDER BY man.name;',
            $rsm
        );

        return $query->setCacheable(true)
            ->getResult();
    }

    /**
     * @return array
     */
    public function findAllBiosManufacturerAdv(): array
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = 'SELECT m.name as biosMan, m2.name as moboMan, mbmc.code
        FROM manufacturer m JOIN manufacturer_bios_manufacturer_code mbmc on m.id = mbmc.bios_manufacturer_id
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
        $sql = 'SELECT m.name as chipsetMan, concat(c.part_no, concat(\' \', c.name)) as chipsetName, cbc.code
        FROM manufacturer m JOIN chipset_bios_code cbc on m.id = cbc.bios_manufacturer_id
        JOIN chipset c on cbc.chipset_id = c.id
        ORDER BY chipsetMan, code;';
        $stmt = $conn->prepare($sql);
        $res = $stmt->executeQuery();

        $data = array();
        foreach ($res->fetchAllAssociative() as $row) {
            $data[$row["chipsetman"]][] = array($row["code"], $row["chipsetname"]);
        }

        return $data;
    }
    public function formatManufacterQuery(string $entity): array
    {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\Manufacturer', 'man');
        $rsm->addFieldResult('man', 'id', 'id');
        $rsm->addFieldResult('man', 'name', 'name');
        return $entityManager->createNativeQuery(
            'SELECT distinct man.id, man.name
            FROM (SELECT distinct man.* FROM manufacturer man JOIN ' . $entity . ' entity ON entity.manufacturer_id = man.id
            UNION SELECT distinct man.* FROM manufacturer man JOIN ' . $entity . '_alias alias ON alias.manufacturer_id = man.id) as man
            ORDER BY man.name;',
            $rsm
        )->setCacheable(true)->getResult();
    }
    public function formatManufacterQueryStorage(string $entity): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT man
            FROM App\Entity' . $entity .' entity, App\Entity\Manufacturer man, App\Entity\StorageDeviceAlias alias
            WHERE entity.manufacturer=man OR (alias.manufacturer=man AND alias.storageDevice=entity)
            ORDER BY man.name ASC'
        );
        return $query->getResult();
    }

    /**
     * @return Manufacturer[]
     */
    public function findAllChipManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT man
            FROM App\Entity\Chip ac, App\Entity\Manufacturer man 
            WHERE ac.manufacturer=man 
            ORDER BY man.name ASC'
        );

        return $query->getResult();
    }
    /**
     * @return Manufacturer[]
     */
    public function findAllExpansionCardManufacturer(): array
    {
        return $this->formatManufacterQuery('expansion_card');
    }
    /**
     * @return Manufacturer[]
     */
    public function findAllHddManufacturer(): array
    {
        return $this->formatManufacterQueryStorage('\HardDrive');
    }
    /**
     * @return Manufacturer[]
     */
    public function findAllCddManufacturer(): array
    {
        return $this->formatManufacterQueryStorage('\CdDrive');
    }
    /**
     * @return Manufacturer[]
     */
    public function findAllFddManufacturer(): array
    {
        return $this->formatManufacterQueryStorage('\FloppyDrive');
    }
}
