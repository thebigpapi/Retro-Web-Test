<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\MotherboardAliasRepository')]
class MotherboardAlias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Motherboard', inversedBy: 'motherboardAliases')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Manufacturer', inversedBy: 'motherboardAliases')]
    private $manufacturer;
    #[ORM\Column(type: 'string', length: 255)]
    private $name;
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
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
