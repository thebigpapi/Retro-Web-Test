<?php

namespace App\Repository;

use App\Entity\OsFlag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OsFlag|null find($id, $lockMode = null, $lockVersion = null)
 * @method OsFlag|null findOneBy(array $criteria, array $orderBy = null)
 * @method OsFlag[]    findAll()
 * @method OsFlag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OsFlagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OsFlag::class);
    }

    /**
    * @return OsFlag[] Returns an array of OsFlag objects
    */
    public function findByPopularity()
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\OsFlag', 'os');
        //$rsm->addJoinedEntityResult('App\Entity\LargeFile', 'mos', 'os', 'osFlags');
        $rsm->addFieldResult('os', 'id', 'id');
        $rsm->addFieldResult('os', 'name', 'name');

        $query = $entityManager->createNativeQuery(
            "SELECT os.id, count(mos.os_flag_id) as popularity, os.name
            FROM os_flag os LEFT JOIN large_file_os_flag mos ON os.id=mos.os_flag_id GROUP BY os.id, os.name
            ORDER BY popularity DESC;",
            $rsm
        );
        return $query->getResult();
    }
}
