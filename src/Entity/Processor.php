<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProcessorRepository")
 */
class Processor extends ProcessingUnit
{

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Motherboard", mappedBy="processors")
     */
    private $motherboards;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\CacheMethod", inversedBy="processors")
     */
    private $L1CacheMethod;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CacheRatio", inversedBy="processorsL2")
     */
    private $L2CacheRatio;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CacheRatio", inversedBy="processorsL3")
     */
    private $L3CacheRatio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $core;

    /**
     * @ORM\Column(type="float")
     */
    private $voltage;

    /*public function __construct()
    {
        $this->motherboards = new ArrayCollection();
    }*/

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
            $motherboard->addProcessor($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            $motherboard->removeProcessor($this);
        }

        return $this;
    }

    public function getNameWithPlatform() {
        $this->getPlatform() ? $pType = $this->getPlatform()->getName() : $pType = "Unidentified";
        return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name . ' ' . $this->speed->getValueWithUnit() . ' [' . $this->partNumber . ']' . " (" . $pType . ")";
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

    public function getL1CacheMethod(): ?CacheMethod
    {
        return $this->L1CacheMethod;
    }

    public function setL1CacheMethod(?CacheMethod $L1CacheMethod): self
    {
        $this->L1CacheMethod = $L1CacheMethod;

        return $this;
    }

    public function getL2CacheRatio(): ?CacheRatio
    {
        return $this->L2CacheRatio;
    }

    public function setL2CacheRatio(?CacheRatio $L2CacheRatio): self
    {
        $this->L2CacheRatio = $L2CacheRatio;

        return $this;
    }

    public function getL3CacheRatio(): ?CacheRatio
    {
        return $this->L3CacheRatio;
    }

    public function setL3CacheRatio(?CacheRatio $L3CacheRatio): self
    {
        $this->L3CacheRatio = $L3CacheRatio;

        return $this;
    }

    public function getCore(): ?string
    {
        return $this->core;
    }

    public function setCore(?string $core): self
    {
        $this->core = $core;

        return $this;
    }

    public function getVoltage(): ?float
    {
        return $this->voltage;
    }

    public function setVoltage(float $voltage): self
    {
        $this->voltage = $voltage;

        return $this;
    }
}
