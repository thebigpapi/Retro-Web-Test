<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ProcessorRepository')]
class Processor extends ProcessingUnit
{

    #[ORM\ManyToOne(targetEntity: CacheSize::class, inversedBy: 'getProcessorsL2')]
    private $L2;

    #[ORM\ManyToOne(targetEntity: CacheSize::class, inversedBy: 'getProcessorsL3')]
    private $L3;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Core is longer than {{ limit }} characters, try to make it shorter.')]
    private $core;

    #[ORM\Column(type: 'float', nullable: true)]
    private $tdp;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ProcessNode;

    #[ORM\OneToMany(targetEntity: ProcessorVoltage::class, mappedBy: 'processor', orphanRemoval: true, cascade: ['persist'])]
    private $voltages;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $cores = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $threads = null;

    #[ORM\Column(nullable: true)]
    private ?bool $L2shared = null;

    #[ORM\Column(nullable: true)]
    private ?bool $L3shared = null;
    #[ORM\Column(type: 'datetime', mapped: false)]
    private $lastEdited;

    public function __construct()
    {
        parent::__construct();
        $this->voltages = new ArrayCollection();
        $this->documentations = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getName();
    }
    public function getL2(): ?CacheSize
    {
        return $this->L2;
    }
    public function setL2(?CacheSize $L2): self
    {
        $this->L2 = $L2;

        return $this;
    }
    public function getL3(): ?CacheSize
    {
        return $this->L3;
    }
    public function setL3(?CacheSize $L3): self
    {
        $this->L3 = $L3;

        return $this;
    }
    public function getCore(): ?string
    {
        return $this->core;
    }
    public function setCore(?string $core): self
    {
        $this->core = $core;

        return $this;
    }
    public function getTdp(): ?float
    {
        return $this->tdp;
    }
    public function setTdp(?float $tdp): self
    {
        $this->tdp = $tdp;

        return $this;
    }
    public function getProcessNode(): ?int
    {
        return $this->ProcessNode;
    }
    public function setProcessNode(?int $ProcessNode): self
    {
        $this->ProcessNode = $ProcessNode;

        return $this;
    }
    /**
     * @return Collection|ProcessorVoltage[]
     */
    public function getVoltages(): Collection
    {
        return $this->voltages;
    }
    public function addVoltage(ProcessorVoltage $voltage): self
    {
        if (!$this->voltages->contains($voltage)) {
            $this->voltages[] = $voltage;
            $voltage->setProcessor($this);
        }

        return $this;
    }
    public function removeVoltage(ProcessorVoltage $voltage): self
    {
        if ($this->voltages->contains($voltage)) {
            $this->voltages->removeElement($voltage);
            // set the owning side to null (unless already changed)
            if ($voltage->getProcessor() === $this) {
                $voltage->setProcessor(null);
            }
        }

        return $this;
    }
    public function getVoltagesWithValue(): string
    {
        $res = "";
        $voltages = $this->getVoltages();

        foreach ($voltages as $voltage) {
            if ($voltages[array_key_first($voltages->toArray())] ==  $voltage) {
                $res = $voltage->getValueWithUnit();
            } else {
                $res . " - " . $voltage->getValueWithUnit();
            }
        }
        return $res;
    }
    public function getProcessNodeWithValue(): string
    {
        return $this->ProcessNode ? $this->ProcessNode . "nm" : "";
    }
    public function getTdpWithValue(): string
    {
        return $this->tdp ? $this->tdp . "W" : "";
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
    public function getSpeedFSB(){
        return $this->speed->getValueWithUnit() . ($this->fsb != $this->speed ? '/' . $this->fsb->getValueWithUnit() : '');

    }

    public function getCores(): ?int
    {
        return $this->cores;
    }

    public function setCores(?int $cores): self
    {
        $this->cores = $cores;

        return $this;
    }

    public function getThreads(): ?int
    {
        return $this->threads;
    }

    public function setThreads(?int $threads): self
    {
        $this->threads = $threads;

        return $this;
    }

    public function isL2shared(): ?bool
    {
        return $this->L2shared;
    }

    public function setL2shared(?bool $L2shared): self
    {
        $this->L2shared = $L2shared;

        return $this;
    }

    public function isL3shared(): ?bool
    {
        return $this->L3shared;
    }

    public function setL3shared(?bool $L3shared): self
    {
        $this->L3shared = $L3shared;

        return $this;
    }
    public function getAllDocs(): Collection
    {
        $docs = $this->getPlatform()?->getEntityDocumentations()->toArray() ?? [];
        return new ArrayCollection($docs);
    }
}
