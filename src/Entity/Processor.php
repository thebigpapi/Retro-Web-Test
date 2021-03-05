<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Process\Process;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProcessorRepository")
 */
class Processor extends ProcessingUnit
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CacheSize", inversedBy="getProcessorsL1")
     */
    private $L1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CacheSize", inversedBy="getProcessorsL2")
     */
    private $L2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CacheSize", inversedBy="getProcessorsL3")
     */
    private $L3;

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
        $this->getPlatform() ? $pType = $this->getPlatform()->getName() : $pType = "Unidentified";
        return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name . ' ' . $this->speed->getValueWithUnit() . ' [' . $this->chip_no . ']' . " (" . $pType . ")";
    }

    public function getL1(): ?CacheSize
    {
        return $this->L1;
    }

    public function setL1(?CacheSize $L1): self
    {
        $this->L1 = $L1;

        return $this;
    }

    public function getL2(): ?CacheSize
    {
        return $this->L2;
    }

    public function setL2(?CacheSize $L2): self
    {
        $this->L2 = $L2;

        return $this;
    }

    public function getL3(): ?CacheSize
    {
        return $this->L3;
    }

    public function setL3(?CacheSize $L3): self
    {
        $this->L3 = $L3;

        return $this;
    }
}
