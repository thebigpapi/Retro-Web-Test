<?php

namespace App\Entity;

use App\Repository\PciDeviceIdRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PciDeviceIdRepository::class)]
class PciDeviceId
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
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

    public function getDev(): ?string
    {
        if($this->dev > 223 && $this->dev < 234)
            return strtoupper(dechex($this->dev));
        return strtoupper(str_pad(dechex($this->dev), 4, "0", STR_PAD_LEFT));
    }

    public function setDev(string $dev): self
    {
        $this->dev = $this->hex2Int($dev);
        return $this;
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
    public function hex2Int($PCIDEVID)
    {
        //check that characters are in hexadecimal
        if (!preg_match("/^[\da-fA-F]{4}$/", $PCIDEVID)) {
            return false;
        }

        //convert to integer
        return hexdec($PCIDEVID);
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
