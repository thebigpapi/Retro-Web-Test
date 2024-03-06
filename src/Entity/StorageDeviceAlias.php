<?php

namespace App\Entity;

use App\Repository\StorageDeviceAliasRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StorageDeviceAliasRepository::class)]
class StorageDeviceAlias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'chipAliases')]
    private $manufacturer;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max:255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max:255, maxMessage: 'Part number is longer than {{ limit }} characters.')]
    #[Assert\NotBlank(
        message: 'Storage device alias part number cannot be blank'
    )]
    private $partNumber;

    #[ORM\ManyToOne(inversedBy: 'storageDeviceAliases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StorageDevice $storageDevice = null;

    public function __toString(): string
    {
        return $this->getFullAliasName();
    }
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
    public function setPartNumber(?string $partNumber): self
    {
        $this->partNumber = $partNumber;

        return $this;
    }
    public function getFullAliasName(): string
    {
        $fullName = $this->partNumber;
        if ($this->getManufacturer()) {
            $fullName = $this->getManufacturer()->getName() . " " . $fullName;
        } else {
            $fullName = "Unknown " . $fullName;
        }
        if ($this->name) {
            $fullName = $fullName . " ($this->name)";
        }
        return "$fullName";
    }

    public function getStorageDevice(): ?StorageDevice
    {
        return $this->storageDevice;
    }

    public function setStorageDevice(?StorageDevice $storageDevice): self
    {
        $this->storageDevice = $storageDevice;

        return $this;
    }
}
