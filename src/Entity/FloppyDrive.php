<?php

namespace App\Entity;

use App\Repository\FloppyDriveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FloppyDriveRepository::class)]
class FloppyDrive extends StorageDevice
{
    #[ORM\Column(type: 'string', length: 255)]
    private $density;

    #[ORM\Column(type: 'datetime', mapped: false)]
    private $lastEdited;

    public function getDensity(): ?string
    {
        return $this->density;
    }

    public function setDensity(string $density): self
    {
        $this->density = $density;

        return $this;
    }
}
