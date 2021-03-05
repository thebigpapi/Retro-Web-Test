<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstructionSetRepository")
 */
class InstructionSet
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
     * @ORM\ManyToMany(targetEntity="App\Entity\ProcessingUnit", inversedBy="instructionSets")
     */
    private $processingUnits;

    public function __construct()
    {
        $this->processingUnits = new ArrayCollection();
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
            $processingUnit->addInstructionSet($this);
        }

        return $this;
    }

    public function removeProcessingUnit(ProcessingUnit $processingUnit): self
    {
        if ($this->processingUnits->contains($processingUnit)) {
            $this->processingUnits->removeElement($processingUnit);
            // set the owning side to null (unless already changed)
            if ($processingUnit->getInstructionSets() === $this) {
                $processingUnit->removeInstructionSet($this);
            }
        }

        return $this;
    }
}
