<?php

namespace App\Repository;

use App\Entity\ExpansionChipType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionChipType>
 *
 * @method ExpansionChipType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionChipType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionChipType[]    findAll()
 * @method ExpansionChipType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionChipTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionChipType::class);
    }

    public function add(ExpansionChipType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExpansionChipType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ExpansionChipType[] Returns an array of ExpansionChipType objects
     */
    public function findByType(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT expc
            FROM App\Entity\ExpansionChip ac, App\Entity\ExpansionChipType expc
            WHERE ac.type=expc
            ORDER BY expc.name ASC'
        );

        return $query->getResult();
    }

//    public function findOneBySomeField($value): ?ExpansionChipType
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
