<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\InstructionSetRepository')]
class InstructionSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\ManyToMany(targetEntity: ProcessorPlatformType::class, mappedBy: 'instructionSets')]
    private $processorPlatformTypes;

    #[ORM\ManyToMany(targetEntity: InstructionSet::class, inversedBy: 'childInstructionSets')]
    private $compatibleWith;

    #[ORM\ManyToMany(targetEntity: InstructionSet::class, mappedBy: 'compatibleWith')]
    private $childInstructionSets;

    public function __construct()
    {
        $this->processorPlatformTypes = new ArrayCollection();
        $this->compatibleWith = new ArrayCollection();
        $this->childInstructionSets = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->name;
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
     * @return Collection|ProcessorPlatformType[]
     */
    public function getPlatforms(): Collection
    {
        return $this->processorPlatformTypes;
    }
    public function addPlatform(ProcessorPlatformType $processorPlatformType): self
    {
        if (!$this->processorPlatformTypes->contains($processorPlatformType)) {
            $this->processorPlatformTypes[] = $processorPlatformType;
            $processorPlatformType->addInstructionSet($this);
        }

        return $this;
    }
    public function removePlatform(ProcessorPlatformType $processorPlatformType): self
    {
        if ($this->processorPlatformTypes->contains($processorPlatformType)) {
            $this->processorPlatformTypes->removeElement($processorPlatformType);
            // set the owning side to null (unless already changed)
            if ($processorPlatformType->getInstructionSets() === $this) {
                $processorPlatformType->removeInstructionSet($this);
            }
        }

        return $this;
    }
    /**
     * @return Collection|self[]
     */
    public function getCompatibleWith(): Collection
    {
        return $this->compatibleWith;
    }
    public function addCompatibleWith(self $compatibleWith): self
    {
        if (!$this->compatibleWith->contains($compatibleWith)) {
            $this->compatibleWith[] = $compatibleWith;
        }

        return $this;
    }
    public function removeCompatibleWith(self $compatibleWith): self
    {
        if ($this->compatibleWith->contains($compatibleWith)) {
            $this->compatibleWith->removeElement($compatibleWith);
        }

        return $this;
    }
    /**
     * @return Collection|self[]
     */
    public function getChildInstructionSets(): Collection
    {
        return $this->childInstructionSets;
    }
    public function addChildInstructionSet(self $childInstructionSet): self
    {
        if (!$this->childInstructionSets->contains($childInstructionSet)) {
            $this->childInstructionSets[] = $childInstructionSet;
            $childInstructionSet->addCompatibleWith($this);
        }

        return $this;
    }
    public function removeChildInstructionSet(self $childInstructionSet): self
    {
        if ($this->childInstructionSets->contains($childInstructionSet)) {
            $this->childInstructionSets->removeElement($childInstructionSet);
            $childInstructionSet->removeCompatibleWith($this);
        }

        return $this;
    }
}
