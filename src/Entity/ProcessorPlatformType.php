<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProcessorPlatformTypeRepository")
 */
class ProcessorPlatformType
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
     * @ORM\OneToMany(targetEntity="App\Entity\Processor", mappedBy="processorPlatformType")
     */
    private $processors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Motherboard", mappedBy="processorPlatformType")
     */
    private $motherboards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Coprocessor", mappedBy="processor_platform_type")
     */
    private $coprocessors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProcessingUnit", mappedBy="platform")
     */
    private $processingUnits;

    public function __construct()
    {
        $this->processors = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
        $this->coprocessors = new ArrayCollection();
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
     * @return Collection|Processor[]
     */
    public function getProcessors(): Collection
    {
        return $this->processors;
    }

    public function addProcessor(Processor $processor): self
    {
        if (!$this->processors->contains($processor)) {
            $this->processors[] = $processor;
            $processor->setProcessorPlatformType($this);
        }

        return $this;
    }

    public function removeProcessor(Processor $processor): self
    {
        if ($this->processors->contains($processor)) {
            $this->processors->removeElement($processor);
            // set the owning side to null (unless already changed)
            if ($processor->getProcessorPlatformType() === $this) {
                $processor->setProcessorPlatformType(null);
            }
        }

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
            $motherboard->setProcessorPlatformType($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            // set the owning side to null (unless already changed)
            if ($motherboard->getProcessorPlatformType() === $this) {
                $motherboard->setProcessorPlatformType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Coprocessor[]
     */
    public function getCoprocessors(): Collection
    {
        return $this->coprocessors;
    }

    public function addCoprocessor(Coprocessor $coprocessor): self
    {
        if (!$this->coprocessors->contains($coprocessor)) {
            $this->coprocessors[] = $coprocessor;
            $coprocessor->setProcessorPlatformType($this);
        }

        return $this;
    }

    public function removeCoprocessor(Coprocessor $coprocessor): self
    {
        if ($this->coprocessors->contains($coprocessor)) {
            $this->coprocessors->removeElement($coprocessor);
            // set the owning side to null (unless already changed)
            if ($coprocessor->getProcessorPlatformType() === $this) {
                $coprocessor->setProcessorPlatformType(null);
            }
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
}
