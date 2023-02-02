<?php

namespace App\Entity;

use App\Repository\PciVendorIdRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PciVendorIdRepository::class)]
class PciVendorId
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ven = null;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'pciVendorIds')]
    private $manufacturer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVen(): ?string
    {
        return strtoupper(dechex($this->ven));
    }

    public function setVen(?string $ven): self
    {
        $this->ven = $this->hex2Int($ven);
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
