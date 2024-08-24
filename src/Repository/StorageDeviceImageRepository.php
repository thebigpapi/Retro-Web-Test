<?php

namespace App\Repository;

use App\Entity\StorageDeviceImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StorageDeviceImage>
 *
 * @method StorageDeviceImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method StorageDeviceImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method StorageDeviceImage[]    findAll()
 * @method StorageDeviceImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StorageDeviceImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StorageDeviceImage::class);
    }

    public function save(StorageDeviceImage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StorageDeviceImage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllImages(): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT entity.file_name
            FROM App\Entity\StorageDeviceImage entity
            WHERE entity.file_name NOT LIKE '%.svg%'"
        );
        $result = array_column($query->setMaxResults(10)->getResult(), "file_name");
        foreach($result as &$r)
            $r = "/storage/image/" . $r;

        return $result;
    }
}
