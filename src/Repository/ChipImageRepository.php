<?php

namespace App\Repository;

use App\Entity\ChipImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChipImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChipImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChipImage[]    findAll()
 * @method ChipImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChipImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChipImage::class);
    }

    public function findAllImages(): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT entity.file_name
            FROM App\Entity\ChipImage entity
            WHERE entity.file_name NOT LIKE '%.svg%'"
        );
        $result = array_column($query->setMaxResults(10)->getResult(), "file_name");
        foreach($result as &$r)
            $r = "/chip/image/" . $r;

        return $result;
    }
}
