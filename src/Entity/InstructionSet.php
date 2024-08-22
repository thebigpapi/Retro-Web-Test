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
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    private $name;

    #[ORM\ManyToMany(targetEntity: ProcessorPlatformType::class, mappedBy: 'instructionSets')]
    private $processorPlatformTypes;

    public function __construct()
    {
        $this->processorPlatformTypes = new ArrayCollection();
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
}
