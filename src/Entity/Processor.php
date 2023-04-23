<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProcessorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProcessorRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'read:Processor:item'],
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => ['read:Processor:list', 'read:Chip:list']]],
        'post' => ['denormalization_context' => ['groups' => 'write:Processor']]
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => ['read:Processor:item', 'read:Chip:item']]],
        'put' => ['denormalization_context' => ['groups' => 'write:Processor']],
        'delete'
    ],
    order: ['name' => 'ASC'],
    paginationEnabled: true,
)]
class Processor extends ProcessingUnit
{
    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'processors')]
    private $motherboards;

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
    #[Groups(['read:Processor:list', 'read:Processor:item', 'write:Processor'])]
    private $core;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['read:Processor:list', 'read:Processor:item', 'write:Processor'])]
    private $tdp;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['read:Processor:list', 'read:Processor:item', 'write:Processor'])]
    private $ProcessNode;

    #[ORM\OneToMany(targetEntity: ProcessorVoltage::class, mappedBy: 'processor', orphanRemoval: true, cascade: ['persist'])]
    private $voltages;

    public function __construct()
    {
        parent::__construct();
        $this->motherboards = new ArrayCollection();
        $this->voltages = new ArrayCollection();
        $this->documentations = new ArrayCollection();
    }
    /**
     * @return Collection|Motherboard[]
     */
    public function getMotherboards(): Collection
    {
        return $this->motherboards;
    }
    public function addMotherboard(Motherboard $motherboard): self
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->addProcessor($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            $motherboard->removeProcessor($this);
        }

        return $this;
    }
    #[Groups(['read:Processor:list', 'read:Processor:item'])]
    public function getPlatform(): ?ProcessorPlatformType
    {
        return $this->platform;
    }
    #[Groups(['write:Processor'])]
    public function setPlatform(?ProcessorPlatformType $platform): self
    {
        $this->platform = $platform;

        return $this;
    }
    #[Groups(['read:Processor:list', 'read:Processor:item'])]
    public function getSpeed(): ?CpuSpeed
    {
        return $this->speed;
    }
    #[Groups(['write:Processor'])]
    public function setSpeed(?CpuSpeed $speed): self
    {
        $this->speed = $speed;

        return $this;
    }
    #[Groups(['read:Processor:list', 'read:Processor:item'])]
    public function getFsb(): ?CpuSpeed
    {
        return $this->fsb;
    }
    #[Groups(['write:Processor'])]
    public function setFsb(?CpuSpeed $fsb): self
    {
        $this->fsb = $fsb;

        return $this;
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
        return implode(" ", array($this->getManufacturer()->getShortNameIfExist(), $this->partNumber, "[" . implode(", ", $inner) . "]"));
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

        return implode(" ", array($this->getManufacturer()->getShortNameIfExist(), $this->name, $core, $speed, $voltages, $cache, $partno, $pType, $processNode, $tdp));
    }
    #[Groups(['read:Processor:list', 'read:Processor:item'])]
    public function getL1(): ?CacheSize
    {
        return $this->L1;
    }
    #[Groups(['write:Processor'])]
    public function setL1(?CacheSize $L1): self
    {
        $this->L1 = $L1;

        return $this;
    }
    #[Groups(['read:Processor:list', 'read:Processor:item'])]
    public function getL2(): ?CacheSize
    {
        return $this->L2;
    }
    #[Groups(['write:Processor'])]
    public function setL2(?CacheSize $L2): self
    {
        $this->L2 = $L2;

        return $this;
    }
    #[Groups(['read:Processor:list', 'read:Processor:item'])]
    public function getL3(): ?CacheSize
    {
        return $this->L3;
    }
    #[Groups(['write:Processor'])]
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
    #[Groups(['read:Processor:list', 'read:Processor:item'])]
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
            $fullName = $this->getManufacturer()->getShortNameIfExist() . " " . $fullName;
        } else {
            $fullName = "Unknown " . $fullName;
        }
        return "$fullName";
    }
}
