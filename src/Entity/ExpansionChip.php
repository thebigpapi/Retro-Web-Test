<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\ExpansionChipRepository')]
class ExpansionChip extends Chip
{
    public function __construct()
    {
        parent::__construct();
        $this->documentations = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getFullName() . $this->getAllAliases();
    }
    
    public function getFullName(): string
    {
        $name = $this->getManufacturer()?->getName() ?? "[unknown]";
        if ($this->name) {
            return $name . " " . $this->partNumber . " (" . $this->name . ")";
        }
        return $name . " " . $this->partNumber;
    }
    public function getAllAliases(): string
    {
        if($this->getChipAliases()->isEmpty())
            return "";
        $aliases = " [";
        foreach($this->getChipAliases() as $alias){
            $aliases .= $alias->getPartNumber() ? $alias->getPartNumber() . ", ": "";
        }
        return substr($aliases, 0, -2) . "]";
    }
    public function getManufacturerAndPN()
    {
        return ($this->getManufacturer()?->getName() ?? '[unknown]') . " " . $this->partNumber;
    }
    
    public function getChipsWithDrivers(): array
    {
        return [];
    }
}
