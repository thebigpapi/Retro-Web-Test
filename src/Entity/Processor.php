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

    #[ORM\ManyToOne(targetEntity: CacheSize::class, inversedBy: 'getProcessorsL1')]
    private $L1;

    #[ORM\ManyToOne(targetEntity: CacheSize::class, inversedBy: 'getProcessorsL2')]
    private $L2;

    #[ORM\ManyToOne(targetEntity: CacheSize::class, inversedBy: 'getProcessorsL3')]
    private $L3;

    #[ORM\ManyToOne(targetEntity: CacheMethod::class, inversedBy: 'processors')]
    private $L1CacheMethod;

    #[ORM\ManyToOne(targetEntity: CacheRatio::class, inversedBy: 'processorsL2')]
    private $L2CacheRatio;

    #[ORM\ManyToOne(targetEntity: CacheRatio::class, inversedBy: 'processorsL3')]
    private $L3CacheRatio;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Core is longer than {{ limit }} characters, try to make it shorter.')]
    private $core;

    #[ORM\Column(type: 'float', nullable: true)]
    private $tdp;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ProcessNode;

    #[ORM\OneToMany(targetEntity: ProcessorVoltage::class, mappedBy: 'processor', orphanRemoval: true, cascade: ['persist'])]
    private $voltages;

    #[ORM\Column(type: 'datetime', mapped: false)]
    private $lastEdited;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $cores = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $threads = null;

    public function __construct()
    {
        parent::__construct();
        $this->voltages = new ArrayCollection();
        $this->documentations = new ArrayCollection();
    }
    public function getNameWithPlatform()
    {
        $inner = array();
        if($this->core != "")
            array_push($inner, $this->core);
        if($this->fsb != "")
            array_push($inner, $this->fsb->getValueWithUnit());
        if($this->getVoltagesWithValue() != "")
            array_push($inner, $this->getVoltagesWithValue());
        if($this->ProcessNode != "")
            array_push($inner, ($this->ProcessNode ? $this->ProcessNode . 'nm' : ''));
        if($this->tdp != "")
            array_push($inner, ($this->tdp ? $this->tdp . 'W' : ''));
        return implode(" ", array($this->getManufacturer()->getName(), $this->partNumber, "[" . implode(", ", $inner) . "]"));
    }
    public function getNameWithSpecs()
    {

        $cache = $this->getCachesWithValue();

        $core = $this->getCore() ? "($this->core)" : '';

        $speed = $this->speed->getValueWithUnit() . ($this->fsb != $this->speed ? '/' . $this->fsb->getValueWithUnit() : '');

        $voltages = $this->getVoltagesWithValue();

        $partno = "[$this->partNumber]";

        $pType = '(' . ($this->getPlatform() ? $this->getPlatform()->getName() : "Unidentified") . ')';

        $processNode = $this->ProcessNode ? $this->ProcessNode . 'nm' : '';

        $tdp = $this->tdp ? $this->tdp . 'W' : '';

        return implode(" ", array($this->getManufacturer()->getName(), $this->name, $core, $speed, $voltages, $cache, $partno, $pType, $processNode, $tdp));
    }
    public function getL1(): ?CacheSize
    {
        return $this->L1;
    }
    public function setL1(?CacheSize $L1): self
    {
        $this->L1 = $L1;

        return $this;
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
    public function getL1CacheMethod(): ?CacheMethod
    {
        return $this->L1CacheMethod;
    }
    public function setL1CacheMethod(?CacheMethod $L1CacheMethod): self
    {
        $this->L1CacheMethod = $L1CacheMethod;

        return $this;
    }
    public function getL2CacheRatio(): ?CacheRatio
    {
        return $this->L2CacheRatio;
    }
    public function setL2CacheRatio(?CacheRatio $L2CacheRatio): self
    {
        $this->L2CacheRatio = $L2CacheRatio;

        return $this;
    }
    public function getL3CacheRatio(): ?CacheRatio
    {
        return $this->L3CacheRatio;
    }
    public function setL3CacheRatio(?CacheRatio $L3CacheRatio): self
    {
        $this->L3CacheRatio = $L3CacheRatio;

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
    public static function sort(Collection $processors): Collection
    {
        $array = $processors->toArray();
        usort(
            $array,
            function (Processor $a, Processor $b) {
                if ($a->getFsb() != $b->getFsb()) {
                    return ($a->getFsb()->getValue() > $b->getFsb()->getValue()) ? -1 : 1;
                }
                if ($a->getProcessNode() != $b->getProcessNode()) {
                    return ($a->getProcessNode() < $b->getProcessNode()) ? -1 : 1;
                }
                if ($a->getSpeed() != $b->getSpeed()) {
                    return ($a->getSpeed()->getValue() > $b->getSpeed()->getValue()) ? -1 : 1;
                }
                if ($a->getManufacturer() != $b->getManufacturer()) {
                    return ($a->getManufacturer() < $b->getManufacturer()) ? -1 : 1;
                }
                return 0;
            }
        );

        return new ArrayCollection($array);
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
    public function getCachesWithValue(): string
    {
        $cache = '';
        if ($this->L1) {
            $cache = "[L1: " . $this->L1->getValueWithUnit();
            if ($this->L1CacheMethod) {
                $cache = "$cache " . $this->L1CacheMethod->getName();
            }
            if ($this->L2) {
                $cache = "$cache, L2: " . $this->L2->getValueWithUnit();
                if ($this->L2CacheRatio) {
                    $cache = "$cache " . $this->L2CacheRatio->getName();
                }
                if ($this->L3) {
                    $cache = "$cache, L3: " . $this->L3->getValueWithUnit();
                    if ($this->L3CacheRatio) {
                        $cache = "$cache " . $this->L3CacheRatio->getName();
                    }
                }
            }
            $cache = "$cache]";
        }
        return $cache;
    }
    public function getProcessNodeWithValue(): string
    {
        return $this->ProcessNode ? $this->ProcessNode . "nm" : "";
    }
    public function getTdpWithValue(): string
    {
        return $this->tdp ? $this->tdp . "W" : "";
    }
    public function getNameWithManufacturer()
    {
        $fullName = $this->getNameOnlyPartNumber();
        if ($this->name) {
            $fullName = $fullName . " ($this->name)";
        }
        return "$fullName";
    }
    public function getNameOnlyPartNumber()
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
}
