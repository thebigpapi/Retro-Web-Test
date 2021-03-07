<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoprocessorRepository")
 */
class Coprocessor extends ProcessingUnit
{

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Motherboard", mappedBy="coprocessors")
     */
    private $motherboards;


    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
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
        $this->getPlatform() ? $name = $this->getPlatform()->getName() : $name = "Unidentified";
        return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name . " (" . $name . ")";
    }

}
