<?php

namespace App\Entity;

use App\Repository\HardDriveRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HardDriveRepository::class)]
class HardDrive extends StorageDevice
{
    #[ORM\Column(type: 'integer')]
    #[Assert\LessThan(4294967295, message: "Capacity should be smaller than 4294967295")]
    #[Assert\Positive(message: "Capacity should be above 0")]
    private $capacity;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\LessThan(65536, message: "Cylinders should be smaller than 65536")]
    #[Assert\Positive(message: "Cylinders should be above 0")]
    private $cylinders;

    #[ORM\Column(type: 'smallint', nullable: true)]
    #[Assert\LessThan(32768, message: "Heads should be smaller than 32768")]
    #[Assert\Positive(message: "Heads should be above 0")]
    private $heads;

    #[ORM\Column(type: 'smallint', nullable: true)]
    #[Assert\LessThan(32768, message: "Sectors per track should be smaller than 32768")]
    #[Assert\Positive(message: "Sectors per track should be above 0")]
    private $sectors;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\LessThan(65536, message: "RPM should be smaller than 65536")]
    #[Assert\Positive(message: "RPM should be above 0")]
    private $spindleSpeed;

    #[ORM\Column(type: 'smallint', nullable: true)]
    #[Assert\LessThan(32768, message: "Platter count should be smaller than 32768")]
    #[Assert\Positive(message: "Platter count should be above 0")]
    private $platters;

    #[ORM\Column(type: 'datetime', mapped: false)]
    private $lastEdited;

    #[ORM\Column(nullable: true)]
    #[Assert\LessThan(4294967295, message: "Buffer size should be smaller than 4294967295")]
    #[Assert\Positive(message: "Buffer size should be above 0")]
    private ?int $buffer = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive(message: "Random seek time should be above 0")]
    private ?float $randomSeek = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive(message: "Random seek time should be above 0")]
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
        if(!$this->buffer)
            return "None/Unknown";
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
