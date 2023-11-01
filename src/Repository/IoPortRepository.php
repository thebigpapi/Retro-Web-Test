<?php

namespace App\Repository;

use App\Entity\IoPort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IoPort|null find($id, $lockMode = null, $lockVersion = null)
 * @method IoPort|null findOneBy(array $criteria, array $orderBy = null)
 * @method IoPort[]    findAll()
 * @method IoPort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method IoPort[]    findByPopularity()
 */
class IoPortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IoPort::class);
    }

    /**
    * @return IoPort[] Returns an array of IoPort objects
    */
    public function findByPopularity()
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\IoPort', 'io');
        $rsm->addJoinedEntityResult('App\Entity\MotherboardIoPort', 'moboio', 'io', 'motherboardIoPorts');
        $rsm->addFieldResult('io', 'id', 'id');
        $rsm->addFieldResult('io', 'name', 'name');

        $query = $entityManager->createNativeQuery(
            "SELECT io.id, count(moboio.io_port_id) as popularity, io.name
            FROM io_port io LEFT JOIN motherboard_io_port moboio ON io.id=moboio.io_port_id GROUP BY io.id, io.name
            ORDER BY popularity DESC;",
            $rsm
        );
        return $query->getResult();
    }
}
