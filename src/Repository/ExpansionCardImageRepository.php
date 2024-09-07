<?php

namespace App\Repository;

use App\Entity\ExpansionCardImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionCardImage>
 *
 * @method ExpansionCardImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpansionCardImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpansionCardImage[]    findAll()
 * @method ExpansionCardImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionCardImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionCardImage::class);
    }

    public function findAllImages(): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT entity.file_name
            FROM App\Entity\ExpansionCardImage entity
            WHERE entity.file_name NOT LIKE '%.svg%'"
        );
        $result = array_column($query->getResult(), "file_name");
        foreach($result as &$r)
            $r = "/expansioncard/image/" . $r;

        return $result;
    }
}
