<?php

namespace App\Repository;

use App\Entity\Coprocessor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Coprocessor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coprocessor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coprocessor[]    findAll()
 * @method Coprocessor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Coprocessor[]    findAllOrderByManufacturer()
 */
class CoprocessorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coprocessor::class);
    }

    /**
     * @return Corocessor[]
     */
    public function findAllOrderByManufacturer(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT cpu
            FROM App\Entity\Coprocessor cpu, App\Entity\Manufacturer man 
            WHERE cpu.manufacturer=man 
            ORDER BY cpu.name ASC'
        );

        return $query->getResult();
    }

    // /**
    //  * @return Coprocessor[] Returns an array of Coprocessor objects
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
    public function findOneBySomeField($value): ?Coprocessor
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
