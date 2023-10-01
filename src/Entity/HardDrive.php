<?php

namespace App\Entity;

use App\Repository\HardDriveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HardDriveRepository::class)]
class HardDrive extends StorageDevice
{
    #[ORM\Column(type: 'integer')]
    private $capacity;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $cylinders;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $heads;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $sectors;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $spindleSpeed;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $platters;

    #[ORM\Column(type: 'datetime', mapped: false)]
    private $lastEdited;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }
    public function setManufacturer(?Manufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }
    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getCylinders(): ?int
    {
        return $this->cylinders;
    }
    public function ehTest(): ?string
    {
        return $this->cylinders + "a";
    }

    public function setCylinders(?int $cylinders): self
    {
        $this->cylinders = $cylinders;

        return $this;
    }

    public function getHeads(): ?int
    {
        return $this->heads;
    }

    public function setHeads(?int $heads): self
    {
        $this->heads = $heads;

        return $this;
    }

    public function getSectors(): ?int
    {
        return $this->sectors;
    }

    public function setSectors(?int $sectors): self
    {
        $this->sectors = $sectors;

        return $this;
    }

    public function getSpindleSpeed(): ?int
    {
        return $this->spindleSpeed;
    }

    public function setSpindleSpeed(?int $spindleSpeed): self
    {
        $this->spindleSpeed = $spindleSpeed;

        return $this;
    }

    public function getPlatters(): ?int
    {
        return $this->platters;
    }

    public function setPlatters(?int $platters): self
    {
        $this->platters = $platters;

        return $this;
    }
}
