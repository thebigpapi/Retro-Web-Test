<?php

namespace App\Repository;

use App\Entity\Trace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trace|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trace|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trace[]    findAll()
 * @method Trace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Trace[]    findAllById($id)
 * @method Trace[]    findAllByIdAndEntity($id, $entity)
 */
class TraceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trace::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Trace $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Trace $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    /**
     * @return Trace[] Returns an array of Trace objects
     */
    public function findAllById($id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT t
            FROM App\Entity\Trace t
            WHERE t.objectId = :likeMatch
            ORDER BY t.date DESC"
        )->setParameter('likeMatch', $id);
        return $query->getResult();
    }
    /**
     * @return Trace[] Returns an array of Trace objects
     */
    public function findAllByIdAndEntity($id, $entity)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT t
            FROM App\Entity\Trace t
            WHERE (t.objectId = :idobj AND t.objectType LIKE :objtype)
            ORDER BY t.date DESC"
        )->setParameter('idobj', $id)->setParameter('objtype', "$entity%");
        $partial_query = $query->getResult();
        $full_query = array();
        foreach($partial_query as $item){
            $newquery = $entityManager->createQuery(
                "SELECT t
                FROM App\Entity\Trace t
                WHERE t.date = :obj
                ORDER BY t.date DESC"
            )->setParameter('obj', $item->getDate());
            $full_query = array_merge($full_query, $newquery->getResult());
        }
        return $full_query;
    }
}
