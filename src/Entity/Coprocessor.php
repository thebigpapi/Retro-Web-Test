<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\CoprocessorRepository')]
class Coprocessor extends ProcessingUnit
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getNameWithManufacturer()
    {
        return $this->getManufacturer()->getName() . " " . $this->name;
    }
    public function getNameWithPlatform()
    {
        $this->getPlatform() ? $name = $this->getPlatform()->getName() : $name = "Unidentified";
        return $this->getManufacturer()->getName() . " " . $this->name . " (" . $name . ")";
    }
    public function getSpeedFSB(){
        return $this->speed->getValueWithUnit() . ($this->fsb != $this->speed ? '/' . $this->fsb->getValueWithUnit() : '');

    }
}
