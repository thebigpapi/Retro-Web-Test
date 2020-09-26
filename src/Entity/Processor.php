<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProcessorRepository")
 */
class Processor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manufacturer", inversedBy="processors")
     * @ORM\OrderBy({"name" = "ASC", "shortName" = "ASC"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $manufacturer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProcessorPlatformType", inversedBy="processors")
     */
    private $processorPlatformType;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Motherboard", mappedBy="motherboardProcessor")
     */
    private $motherboards;

    public function __construct()
    {
        $this->motherboardProcessors = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->processorPlatformType;
    }

    public function setProcessorPlatformType(?ProcessorPlatformType $processorPlatformType): self
    {
        $this->processorPlatformType = $processorPlatformType;

        return $this;
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
            $motherboard->addMotherboardProcessor($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            $motherboard->removeMotherboardProcessor($this);
        }

        return $this;
    }

    public function getNameWithPlatform() {
        $this->getProcessorPlatformType() ? $pType = $this->getProcessorPlatformType()->getName() : $pType = "Unidentified";
        return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name . " (" . $pType . ")";
    }
}
