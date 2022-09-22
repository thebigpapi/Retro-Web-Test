<?php

namespace App\Repository;

use App\Entity\LargeFileAudioChipset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LargeFileAudioChipset|null find($id, $lockMode = null, $lockVersion = null)
 * @method LargeFileAudioChipset|null findOneBy(array $criteria, array $orderBy = null)
 * @method LargeFileAudioChipset[]    findAll()
 * @method LargeFileAudioChipset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LargeFileAudioChipsetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LargeFileAudioChipset::class);
    }
}
