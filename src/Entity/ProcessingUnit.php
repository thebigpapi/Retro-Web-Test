<?php

namespace App\Entity;

use App\Repository\ProcessingUnitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProcessingUnitRepository::class)]
#[ORM\InheritanceType('JOINED')]
abstract class ProcessingUnit extends Chip
{
    public function __construct()
    {
        parent::__construct();
    } 
}
