<?php

namespace App\Repository;

use App\Entity\MotherboardBios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MotherboardBios|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardBios|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardBios[]    findAll()
 * @method MotherboardBios[]    findAllDistinct()
 * @method MotherboardBios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardBiosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardBios::class);
    }

    public function findAllDistinct()
    {
        return $this->createQueryBuilder('m')
            ->groupBy('m.manufacturer')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBios(array $criterias)
    {
        $query = $this->createQueryBuilder('b');
        $query->join('b.motherboard', 'm');

        if(array_key_exists('file_present', $criterias))
            $query->andWhere($query->expr()->isNotNull('b.file_name'));

        if(array_key_exists('manufacturer_id', $criterias))
            $query->andWhere('b.manufacturer = :manufacturer_id')
                ->setParameter('manufacturer_id', $criterias['manufacturer_id']);

        if(array_key_exists('motherboard_manufacturer_ids', $criterias))
        {   
            $cpt = 0;
            $str = "";
            foreach($criterias['motherboard_manufacturer_ids'] as $key => $id)
            {
                if(array_key_last($criterias['motherboard_manufacturer_ids']) == $key)
                    $str = "$str m.manufacturer = :manufacturer_id$cpt";
                else
                    $str = "$str m.manufacturer = :manufacturer_id$cpt OR ";
                $cpt++;
            }
            
            $query->andWhere("($str)");
            $cpt = 0;
            foreach($criterias['motherboard_manufacturer_ids'] as $key => $id) {
                $query->setParameter("manufacturer_id$cpt", $id);
            }
                
        }
        if(array_key_exists('chipset_id', $criterias))
            $query->andWhere('m.chipset = :chipset_id')
                ->setParameter('chipset_id', $criterias['chipset_id']);
        
        if(array_key_exists('core_version', $criterias))
            $query->andWhere('b.coreVersion = :coreVersion')
                ->setParameter('coreVersion', $criterias['core_version']);

        if(array_key_exists('post_string', $criterias) && !array_key_exists('motherboard_manufacturer_ids', $criterias))
            $query->andWhere($query->expr()->like('b.postString', ':postString'))
                ->setParameter('postString', '%'.$criterias['post_string'].'%');
        
        return $query->orderBy('b.postString', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return MotherboardBios[] Returns an array of MotherboardBios objects
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
    public function findOneBySomeField($value): ?MotherboardBios
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
