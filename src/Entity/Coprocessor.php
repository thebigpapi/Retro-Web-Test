<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoprocessorRepository")
 */
class Coprocessor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manufacturer")
     */
    private $manufacturer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProcessorPlatformType", inversedBy="coprocessors")
     */
    private $processor_platform_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Motherboard", mappedBy="coprocessors")
     */
    private $motherboards;


    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
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

    public function getProcessorPlatformType(): ?ProcessorPlatformType
    {
        return $this->processor_platform_type;
    }

    public function setProcessorPlatformType(?ProcessorPlatformType $processor_platform_type): self
    {
        $this->processor_platform_type = $processor_platform_type;

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
    
    public function getNameWithManufacturer() 
    {
        return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name;
    }

    /**
     * @return Collection|Motherboard[]
     */
    public function getMotherboards(): Collection
    {
        return $this->motherboards;
    }

    public function addMotherboard(Motherboard $motherboard): self
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->addCoprocessor($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            $motherboard->removeCoprocessor($this);
        }

        return $this;
    }

    public function getNameWithPlatform() {
        $this->getProcessorPlatformType() ? $name = $this->getProcessorPlatformType()->getName() : $name = "Unidentified";
        return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name . " (" . $name . ")";
    }

}
