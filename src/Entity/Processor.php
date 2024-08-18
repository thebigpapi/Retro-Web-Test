<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\ProcessorRepository')]
class Processor extends ProcessingUnit
{
    public function __construct()
    {
        parent::__construct();
    }
    public function __toString(): string
    {
        return $this->getFullName() . $this->getAllAliases();
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
    
    public function getFullName(): string
    {
        $fullName = $this->getNameOnlyPartNumber();
        if ($this->name) {
            $fullName = $fullName . " ($this->name)";
        }
        return "$fullName";
    }
    public function getNameOnlyPartNumber(): string
    {
        $fullName = $this->partNumber;
        if ($this->getManufacturer()) {
            $fullName = $this->getManufacturer()->getName() . " " . $fullName;
        } else {
            $fullName = "Unknown " . $fullName;
        }
        return "$fullName";
    }
}
