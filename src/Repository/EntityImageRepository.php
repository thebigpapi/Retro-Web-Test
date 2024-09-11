<?php

namespace App\Repository;

use App\Entity\EntityImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EntityImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityImage[]    findAll()
 * @method EntityImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityImage::class);
    }
    public function findAllImages(): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT entity.file_name
            FROM App\Entity\EntityImage entity
            WHERE entity.file_name NOT LIKE '%.svg%'"
        );
        $result = array_column($query->getResult(), "file_name");
        foreach($result as &$r)
            $r = "/misc/image/" . $r;

        return $result;
    }
}
