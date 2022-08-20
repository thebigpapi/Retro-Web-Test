<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\ManufacturerBiosManufacturerCodeRepository')]
class ManufacturerBiosManufacturerCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Manufacturer', inversedBy: 'biosCodes', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private $manufacturer;
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Manufacturer', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private $biosManufacturer;
    #[ORM\Column(type: 'string', length: 255)]
    private $code;
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
    public function getBiosManufacturer(): ?Manufacturer
    {
        return $this->biosManufacturer;
    }
    public function setBiosManufacturer(?Manufacturer $biosManufacturer): self
    {
        $this->biosManufacturer = $biosManufacturer;

        return $this;
    }
    public function getCode(): ?string
    {
        return $this->code;
    }
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
