<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProcessingUnitRepository")
 * @ORM\InheritanceType("JOINED")
 */
abstract class ProcessingUnit extends Chip
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CpuSpeed", inversedBy="processingUnits")
     * @ORM\OrderBy({"value" = "ASC"})
     */
    protected $speed;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProcessorPlatformType", inversedBy="processingUnits")
     */
    protected $platform;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\InstructionSet", mappedBy="processingUnits")
     */
    protected $instructionSets;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CpuSpeed", inversedBy="processingUnitsFsb")
     * @ORM\OrderBy({"value" = "ASC"})
     */
    protected $fsb;

    public function __construct()
    {
        parent::__construct();
        $this->instructionSets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpeed(): ?CpuSpeed
    {
        return $this->speed;
    }

    public function setSpeed(?CpuSpeed $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getPlatform(): ?ProcessorPlatformType
    {
        return $this->platform;
    }

    public function setPlatform(?ProcessorPlatformType $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @return Collection|InstructionSet[]
     */
    public function getInstructionSets(): Collection
    {
        return $this->instructionSets;
    }

    public function addInstructionSet(InstructionSet $instructionSet): self
    {
        if (!$this->instructionSets->contains($instructionSet)) {
            $this->instructionSets[] = $instructionSet;
            $instructionSet->addProcessingUnit($this);
        }

        return $this;
    }

    public function removeInstructionSet(InstructionSet $instructionSet): self
    {
        if ($this->instructionSets->contains($instructionSet)) {
            $this->instructionSets->removeElement($instructionSet);
            // set the owning side to null (unless already changed)
            if ($instructionSet->getProcessingUnits() === $this) {
                $instructionSet->removeProcessingUnit($this);
            }
        }

        return $this;
    }

    public function getFsb(): ?CpuSpeed
    {
        return $this->fsb;
    }

    public function setFsb(?CpuSpeed $fsb): self
    {
        $this->fsb = $fsb;

        return $this;
    }

    public function getNameWithSpecs() {
        $speed = $speed = $this->speed->getValueWithUnit() . ($this->fsb != $this->speed ? '/'.$this->fsb->getValueWithUnit():'');

        $partno = "[$this->partNumber]";
        
        $pType = '(' . ($this->getPlatform() ? $this->getPlatform()->getName() : "Unidentified") . ')';

        return implode(" ", array($this->getManufacturer()->getShortNameIfExist(),$this->name, $speed, $partno, $pType ));
    }

    public static function sort(Collection $processingUnits): Collection
    {
        $array = $processingUnits->toArray();
        usort($array, function ($a, $b)
            {
                if($a->getManufacturer() == $b->getManufacturer())
                {
                    if($a->getName() == $b->getName())
                    {
                        if($a->getSpeed() == $b->getSpeed())
                        {
                            return 0;
                        }
                        return ($a->getSpeed()->getValue() < $b->getSpeed()->getValue()) ? -1 : 1;
                    }
                    else
                        return ($a->getName() < $b->getName()) ? -1 : 1;
                }
                else
                    return ($a->getManufacturer() < $b->getManufacturer()) ? -1 : 1;
            }
        );
        
        return new ArrayCollection($array);
    }
}
