<?php

namespace App\Entity;

use App\Repository\CdDriveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CdDriveRepository::class)]
class CdDrive extends StorageDevice
{
    #[ORM\Column(type: 'smallint', nullable: true)]
    private $cdReadSpeed;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $cdWriteSpeed;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $dvdReadSpeed;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $dvdWriteSpeed;

    #[ORM\Column(type: 'string', length: 255)]
    private $trayType;

    public function getCdReadSpeed(): ?int
    {
        return $this->cdReadSpeed;
    }

    public function setCdReadSpeed(?int $cdReadSpeed): self
    {
        $this->cdReadSpeed = $cdReadSpeed;

        return $this;
    }

    public function getCdWriteSpeed(): ?int
    {
        return $this->cdWriteSpeed;
    }

    public function setCdWriteSpeed(?int $cdWriteSpeed): self
    {
        $this->cdWriteSpeed = $cdWriteSpeed;

        return $this;
    }

    public function getDvdReadSpeed(): ?int
    {
        return $this->dvdReadSpeed;
    }

    public function setDvdReadSpeed(?int $dvdReadSpeed): self
    {
        $this->dvdReadSpeed = $dvdReadSpeed;

        return $this;
    }

    public function getDvdWriteSpeed(): ?int
    {
        return $this->dvdWriteSpeed;
    }

    public function setDvdWriteSpeed(?int $dvdWriteSpeed): self
    {
        $this->dvdWriteSpeed = $dvdWriteSpeed;

        return $this;
    }

    public function getTrayType(): ?string
    {
        return $this->trayType;
    }

    public function setTrayType(string $trayType): self
    {
        $this->trayType = $trayType;

        return $this;
    }
}
