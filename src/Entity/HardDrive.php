<?php

namespace App\Entity;

use App\Repository\HardDriveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(nullable: true)]
    private ?int $buffer = null;

    #[ORM\Column(nullable: true)]
    private ?float $randomSeek = null;

    #[ORM\Column(nullable: true)]
    private ?float $trackSeek = null;

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
    public function getCapacityFormatted(): ?string
    {
        if($this->capacity > 1048575)
            $size = number_format($this->capacity/1048576, 2, '.', '') . " TB";
        else $size = $this->capacity > 1023 ? number_format($this->capacity/1024, 2, '.', '') . " GB" : $this->capacity . " MB";
        return $size;
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

    public function getBuffer(): ?int
    {
        return $this->buffer;
    }
    public function getBufferFormatted(): ?string
    {
        if($this->buffer > 1048575)
            $size = number_format($this->buffer/1048576, 2, '.', '') . " GB";
        else $size = $this->buffer > 1023 ? number_format($this->buffer/1024, 2, '.', '') . " MB" : $this->buffer . " KB";
        return $size;
    }

    public function setBuffer(?int $buffer): self
    {
        $this->buffer = $buffer;

        return $this;
    }

    public function getRandomSeek(): ?float
    {
        return $this->randomSeek;
    }

    public function setRandomSeek(?float $randomSeek): self
    {
        $this->randomSeek = $randomSeek;

        return $this;
    }

    public function getTrackSeek(): ?float
    {
        return $this->trackSeek;
    }

    public function setTrackSeek(?float $trackSeek): self
    {
        $this->trackSeek = $trackSeek;

        return $this;
    }
}
