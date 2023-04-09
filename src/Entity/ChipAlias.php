<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ChipAliasRepository')]
class ChipAlias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Chip::class, inversedBy: 'chipAliases')]
    #[ORM\JoinColumn(nullable: false)]
    private $chip;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'chipAliases')]
    private $manufacturer;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max:255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max:255, maxMessage: 'Part number is longer than {{ limit }} characters, try to make it shorter.')]
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
    public function getFullAliasRef(): string
    {
        $fullName = "";
        if ($this->partNumber) {
            $fullName = $fullName . " $this->partNumber";
            if ($this->name) {
                $fullName = $fullName . " ($this->name)";
            }
        } else {
            if ($this->name) {
                $fullName = $fullName . " $this->name";
            } else {
                $fullName = $fullName . " Unidentified";
            }
        }
        return "$fullName";
    }
    public function getFullAliasName(): string
    {
        if ($this->getManufacturer()) {
            $manuf = $this->getManufacturer()->getShortNameIfExist();
        } else {
            $manuf = "";
        }

        $fullName = $manuf . $this->getFullAliasRef();
        return "$fullName";
    }
    public function getFullAliasRefRev(): string
    {
        $fullName = "";
        if ($this->name) {
            $fullName =" " . $this->name . " ($this->partNumber)";
        }
        else{
            $fullName =" $this->partNumber";
        }
        return "$fullName";
    }
    public function getFullAliasNameRev(): string
    {
        if ($this->getManufacturer()) {
            $manuf = $this->getManufacturer()->getShortNameIfExist();
        } else {
            $manuf = "";
        }

        $fullName = $manuf . $this->getFullAliasRefRev();
        return "$fullName";
    }
}
