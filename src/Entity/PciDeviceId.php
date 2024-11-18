<?php

namespace App\Entity;

use App\Repository\PciDeviceIdRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

#[ORM\Entity(repositoryClass: PciDeviceIdRepository::class)]
class PciDeviceId
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Column(type: Types::INTEGER)]
    private ?int $dev = null;

    #[ORM\ManyToOne(targetEntity: Chip::class, inversedBy: 'pciDevs')]
    private $chip;

    #[ORM\ManyToOne(inversedBy: 'pciDevs')]
    private ?ExpansionCard $expansionCard = null;

    public function __toString(): string
    {
        return $this->getDev();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDev(): ?int
    {
        return $this->dev;
    }

    public function setDev(string $dev): self
    {
        $this->dev = $dev;
        return $this;
    }

    public function getHexDev(): string
    {
        return strtoupper(str_pad(dechex($this->dev), 4, "0", STR_PAD_LEFT));
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

    public function getExpansionCard(): ?ExpansionCard
    {
        return $this->expansionCard;
    }

    public function setExpansionCard(?ExpansionCard $expansionCard): static
    {
        $this->expansionCard = $expansionCard;

        return $this;
    }
}
