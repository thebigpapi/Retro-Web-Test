<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\ChipAliasRepository')]
class ChipAlias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Chip', inversedBy: 'chipAliases')]
    #[ORM\JoinColumn(nullable: false)]
    private $chip;
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Manufacturer', inversedBy: 'chipAliases')]
    private $manufacturer;
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;
    #[ORM\Column(type: 'string', length: 255)]
    private $partNumber;
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getChip(): ?Chip
    {
        return $this->chip;
    }
    public function setChip(?Chip $chip): self
    {
        $this->chip = $chip;

        return $this;
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
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getPartNumber(): ?string
    {
        return $this->partNumber;
    }
    public function setPartNumber(string $partNumber): self
    {
        $this->partNumber = $partNumber;

        return $this;
    }
}
