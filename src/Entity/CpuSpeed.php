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

    public function __construct()
    {
        $this->motherboardCpuSpeeds = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
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
}
