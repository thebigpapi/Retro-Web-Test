<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ProcessorPlatformTypeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'read:ProcessorPlatformType:item']),
        new Put(denormalizationContext: ['groups' => 'write:ProcessorPlatformType']),
        new Delete(),
        new GetCollection(normalizationContext: ['groups' => 'read:ProcessorPlatformType:list']),
        new Post(denormalizationContext: ['groups' => 'write:ProcessorPlatformType'])
    ],
    normalizationContext: ['groups' => 'read:ProcessorPlatformType:item'],
    order: ['name' => 'ASC'],
    paginationEnabled: false
)]
#[ORM\Entity(repositoryClass: ProcessorPlatformTypeRepository::class)]
class ProcessorPlatformType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:ProcessorPlatformType:list', 'read:ProcessorPlatformType:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    #[Groups(['read:ProcessorPlatformType:list', 'read:ProcessorPlatformType:item', 'write:ProcessorPlatformType'])]
    private $name;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'processorPlatformTypes')]
    private $motherboards;

    #[ORM\OneToMany(targetEntity: ProcessingUnit::class, mappedBy: 'platform')]
    private $processingUnits;

    #[ORM\ManyToMany(targetEntity: ProcessorPlatformType::class, inversedBy: 'ChildProcessorPlatformType')]
    #[Groups(['read:ProcessorPlatformType:item', 'write:ProcessorPlatformType'])]
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
     * @return Collection|Coprocessor[]
     */
    public function getCoprocessors(): Collection
    {
        $coprocessors = array();
        foreach ($this->processingUnits as $coprocessor) {
            if ($coprocessor instanceof Coprocessor) {
                $coprocessors[] = $coprocessor;
            }
        }
        return new ArrayCollection($coprocessors);
    }
    /**
     * @return Collection|Coprocessor[]
     */
    public function getCompatibleCoprocessors(): Collection
    {
        $coprocessors = $this->getProcessors()->toArray();
        foreach ($this->getCompatibleWith() as $compatible) {
            $coprocessors = array_merge($coprocessors, $compatible->getCoprocessors()->toArray());
        }
        return new ArrayCollection($coprocessors);
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
