<?php

namespace App\Repository;

use App\Entity\Chipset;
use App\Entity\Manufacturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    public function findByChipset(array $criteria): array
    {
        $entityManager = $this->getEntityManager();
        $arrays = array();
        $values = array();
        $name = NULL;
        $manufacturer = NULL;
        $this->separateArraysFromValues($criteria, $arrays, $values);
        if (array_key_exists('name', $values)) {
            $name = strtolower($values['name']);
            unset($values['name']);
        }
        if (array_key_exists('manufacturer', $values)) {
            $manufacturer = $values['manufacturer'];
            unset($values['manufacturer']);
        }
        if($name == NULL){
            $query = $entityManager->createQuery(
                "SELECT chip
                FROM App\Entity\Chipset chip, App\Entity\Manufacturer man 
                WHERE chip.manufacturer=man AND man.id = :likeMatch
                ORDER BY man.name ASC, chip.name ASC"
            )->setParameter('likeMatch', $manufacturer);
        }
        else if($manufacturer == NULL){
            $query = $entityManager->createQuery(
                'SELECT chip
                FROM App\Entity\Chipset chip, App\Entity\Manufacturer man  
                WHERE LOWER(chip.name) LIKE :likeMatch OR LOWER(chip.part_no) LIKE :likeMatch
                ORDER BY man.name ASC, chip.part_no ASC, chip.name ASC'
            )->setParameter('likeMatch', "%$name%");
        }
        else {
            $query = $entityManager->createQuery(
                'SELECT chip
                FROM App\Entity\Chipset chip, App\Entity\Manufacturer man  
                WHERE (chip.manufacturer=man AND man.id = :likeMatch1) AND (LOWER(chip.name) LIKE :likeMatch2 OR LOWER(chip.part_no) LIKE :likeMatch2)
                ORDER BY man.name ASC, chip.part_no ASC, chip.name ASC'
            )->setParameter('likeMatch1', "$manufacturer")->setParameter('likeMatch2', "%$name%");
        }
        return $query->getResult();
    }
    /**
     * @return Chipset[]
     */
    public function findAllAlphabetic(string $letter): array
    {
        $entityManager = $this->getEntityManager();
        if (empty($letter)) {
            $query = $entityManager->createQuery(
                "SELECT chip
                FROM App\Entity\Chipset chip, App\Entity\Manufacturer man 
                WHERE chip.manufacturer=man IS NULL
                ORDER BY man.name ASC, chip.name ASC"
            );
        } else {
            $likematch = "$letter%";
            $query = $entityManager->createQuery(
                "SELECT chip
                FROM App\Entity\Chipset chip, App\Entity\Manufacturer man 
                WHERE chip.manufacturer=man AND COALESCE(man.shortName, man.name) like :likeMatch
                ORDER BY man.name ASC, chip.name ASC"
            )->setParameter('likeMatch', $likematch);
        }

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
    
    public function getCount(): int
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    private function separateArraysFromValues(array $source, array &$arrays, array &$values): void
    {
        foreach ($source as $key => $val) {
            if (is_array($val)) {
                $arrays[$key] = json_decode(json_encode($val), true);
            } else {
                $values[$key] = $val;
            }
        }
    }
}
