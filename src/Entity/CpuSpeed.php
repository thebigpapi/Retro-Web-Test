<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CpuSpeedRepository")
 */
class CpuSpeed
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $value;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Motherboard", mappedBy="cpuSpeed")
     */
    private $motherboards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProcessingUnit", mappedBy="speed")
     */
    private $processingUnits;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProcessingUnit", mappedBy="fsb")
     */
    private $processingUnitsFsb;

    public function __construct()
    {
        $this->motherboardCpuSpeeds = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
        $this->processingUnits = new ArrayCollection();
        $this->processingUnitsFsb = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getValueWithUnit(): ?string
    {
        if($this->value > 1000){
            return ($this->value/1000) . 'GHz';
        }
        else{
            return $this->value . 'MHz';
        }
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

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
            $motherboard->addCpuSpeed($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            $motherboard->removeCpuSpeed($this);
        }

        return $this;
    }

    /**
     * @return Collection|ProcessingUnit[]
     */
    public function getProcessingUnits(): Collection
    {
        return $this->processingUnits;
    }

    public function addProcessingUnit(ProcessingUnit $processingUnit): self
    {
        if (!$this->processingUnits->contains($processingUnit)) {
            $this->processingUnits[] = $processingUnit;
            $processingUnit->setSpeed($this);
        }

        return $this;
    }

    public function removeProcessingUnit(ProcessingUnit $processingUnit): self
    {
        if ($this->processingUnits->contains($processingUnit)) {
            $this->processingUnits->removeElement($processingUnit);
            // set the owning side to null (unless already changed)
            if ($processingUnit->getSpeed() === $this) {
                $processingUnit->setSpeed(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProcessingUnit[]
     */
    public function getProcessingUnitsFsb(): Collection
    {
        return $this->processingUnitsFsb;
    }

    public function addProcessingUnitsFsb(ProcessingUnit $processingUnitsFsb): self
    {
        if (!$this->processingUnitsFsb->contains($processingUnitsFsb)) {
            $this->processingUnitsFsb[] = $processingUnitsFsb;
            $processingUnitsFsb->setFsb($this);
        }

        return $this;
    }

    public function removeProcessingUnitsFsb(ProcessingUnit $processingUnitsFsb): self
    {
        if ($this->processingUnitsFsb->contains($processingUnitsFsb)) {
            $this->processingUnitsFsb->removeElement($processingUnitsFsb);
            // set the owning side to null (unless already changed)
            if ($processingUnitsFsb->getFsb() === $this) {
                $processingUnitsFsb->setFsb(null);
            }
        }

        return $this;
    }
}
