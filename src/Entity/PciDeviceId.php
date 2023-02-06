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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDev(): ?string
    {
        return strtoupper(dechex($this->dev));
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
}