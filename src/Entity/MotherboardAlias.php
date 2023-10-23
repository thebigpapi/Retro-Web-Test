<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\MotherboardAliasRepository')]
class MotherboardAlias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Motherboard::class, inversedBy: 'motherboardAliases')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'motherboardAliases')]
    private $manufacturer;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Alias name is longer than {{ limit }} characters, try to make it shorter.')]
    #[Assert\NotBlank(message: 'Alias name cannot be blank')]
    private $name;

    public function __toString(): string
    {
        $name = "";
        if ($this->manufacturer) {
            $name = $this->manufacturer->getName();
        }
        else{
            $name = "Unknown ";
        }
        return $name . " " . $this->name;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getMotherboard(): ?Motherboard
    {
        return $this->motherboard;
    }
    public function setMotherboard(?Motherboard $motherboard): self
    {
        $this->motherboard = $motherboard;

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
    public function getFullAliasName(): string
    {
        $fullName = $this->name;
        if ($this->getManufacturer()) {
            $fullName = $this->getManufacturer()->getName() . " " . $fullName;
        } else {
            $fullName = "Unknown " . $fullName;
        }
        return "$fullName";
    }

}
