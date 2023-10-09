<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ProcessorPlatformTypeRepository')]
class ProcessorPlatformType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'processorPlatformTypes')]
    private $motherboards;

    #[ORM\OneToMany(targetEntity: ProcessingUnit::class, mappedBy: 'platform')]
    private $processingUnits;

    #[ORM\ManyToMany(targetEntity: ProcessorPlatformType::class, inversedBy: 'ChildProcessorPlatformType')]
    private $compatibleWith;

    #[ORM\ManyToMany(targetEntity: ProcessorPlatformType::class, mappedBy: 'compatibleWith')]
    private $ChildProcessorPlatformType;

    #[ORM\ManyToMany(targetEntity: CpuSocket::class, mappedBy: 'platforms')]
    private $cpuSockets;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->processingUnits = new ArrayCollection();
        $this->compatibleWith = new ArrayCollection();
        $this->ChildProcessorPlatformType = new ArrayCollection();
        $this->cpuSockets = new ArrayCollection();
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
     * @return Collection|Motherboards[]
     */
    public function getMotherboards(): Collection
    {
        return $this->motherboards;
    }
    public function addMotherboards(Motherboard $motherboard): self
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->addProcessorPlatformType($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            if ($this->motherboards->contains($motherboard)) {
                $this->motherboards->removeElement($motherboard);
            }

            return $this;
        }

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
            $processingUnit->setPlatform($this);
        }

        return $this;
    }
    public function removeProcessingUnit(ProcessingUnit $processingUnit): self
    {
        if ($this->processingUnits->contains($processingUnit)) {
            $this->processingUnits->removeElement($processingUnit);
            // set the owning side to null (unless already changed)
            if ($processingUnit->getPlatform() === $this) {
                $processingUnit->setPlatform(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Processor[]
     */
    public function getProcessors(): Collection
    {
        $processors = array();
        foreach ($this->processingUnits as $processor) {
            if ($processor instanceof Processor) {
                $processors[] = $processor;
            }
        }
        return new ArrayCollection($processors);
    }
    /**
     * @return Collection|Processor[]
     */
    public function getCompatibleProcessors(): Collection
    {
        $processors = $this->getProcessors()->toArray();
        foreach ($this->getCompatibleWith() as $compatible) {
            $processors = array_merge($processors, $compatible->getProcessors()->toArray());
        }
        return new ArrayCollection($processors);
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
    public function getChildProcessorPlatformType(): Collection
    {
        return $this->ChildProcessorPlatformType;
    }
    public function addChildProcessorPlatformType(self $childProcessorPlatformType): self
    {
        if (!$this->ChildProcessorPlatformType->contains($childProcessorPlatformType)) {
            $this->ChildProcessorPlatformType[] = $childProcessorPlatformType;
            $childProcessorPlatformType->addCompatibleWith($this);
        }

        return $this;
    }
    public function removeChildProcessorPlatformType(self $childProcessorPlatformType): self
    {
        if ($this->ChildProcessorPlatformType->contains($childProcessorPlatformType)) {
            $this->ChildProcessorPlatformType->removeElement($childProcessorPlatformType);
            $childProcessorPlatformType->removeCompatibleWith($this);
        }

        return $this;
    }
    /**
     * @return Collection|CpuSocket[]
     */
    public function getCpuSockets(): Collection
    {
        return $this->cpuSockets;
    }
    public function addCpuSocket(CpuSocket $cpuSocket): self
    {
        if (!$this->cpuSockets->contains($cpuSocket)) {
            $this->cpuSockets[] = $cpuSocket;
            $cpuSocket->addPlatform($this);
        }

        return $this;
    }
    public function removeCpuSocket(CpuSocket $cpuSocket): self
    {
        if ($this->cpuSockets->contains($cpuSocket)) {
            $this->cpuSockets->removeElement($cpuSocket);
            $cpuSocket->removePlatform($this);
        }

        return $this;
    }
}
