<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ProcessorRepository')]
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
    private $core;

    #[ORM\Column(type: 'float', nullable: true)]
    private $tdp;

    #[ORM\Column(type: 'integer', nullable: true)]
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
        return implode(" ", array($this->getManufacturer()->getShortNameIfExist(), $this->name, "[" . implode(", ", $inner) . "]"));
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
                if ($a->getManufacturer() == $b->getManufacturer()) {
                    if ($a->getPlatform() == $b->getPlatform()) {
                        //if($a->getName() == $b->getName())
                        //{
                        if ($a->getFsb() == $b->getFsb()) {
                            if ($a->getSpeed() == $b->getSpeed()) {
                                if ($a->getProcessNode() == $b->getProcessNode()) {
                                    if ($a->getL1() && $b->getL1()) {
                                        if ($a->getL1() == $b->getL1()) {
                                            if ($a->getL1CacheMethod() && $b->getL1CacheMethod()) {
                                                if ($a->getL1CacheMethod() == $b->getL1CacheMethod()) {
                                                    if ($a->getL2() && $b->getL2()) {
                                                        if ($a->getL2CacheRatio() && $b->getL2CacheRatio()) {
                                                            if ($a->getL2CacheRatio() == $b->getL2CacheRatio()) {
                                                                if ($a->getL3() && $b->getL3()) {
                                                                    if ($a->getL3CacheRatio() && $b->getL3CacheRatio()) {
                                                                        if ($a->getL3CacheRatio() == $b->getL3CacheRatio()) {
                                                                            return 0;
                                                                        }
                                                                        return ($a->getL3CacheRatio()->getName() > $b->getL3CacheRatio()->getName()) ? -1 : 1;
                                                                    }
                                                                    return ($a->getL3()->getValue() > $b->getL3()->getValue()) ? -1 : 1;
                                                                }
                                                            }
                                                            return ($a->getL2CacheRatio()->getName() > $b->getL2CacheRatio()->getName()) ? -1 : 1;
                                                        }
                                                        return ($a->getL2()->getValue() > $b->getL2()->getValue()) ? -1 : 1;
                                                    }
                                                    return ($a->getL2() && !$b->getL2()) ? -1 : 1;
                                                }
                                                return ($a->getL1CacheMethod()->getName() > $b->getL1CacheMethod()->getName()) ? -1 : 1;
                                            }
                                        }
                                        return ($a->getL1()->getValue() > $b->getL1()->getValue()) ? -1 : 1;
                                    }
                                    return ($a->getL1() && !$b->getL1()) ? -1 : 1;
                                }
                                return ($a->getProcessNode() < $b->getProcessNode()) ? -1 : 1;
                            }
                            return ($a->getSpeed()->getValue() > $b->getSpeed()->getValue()) ? -1 : 1;
                        }
                        return ($a->getFsb()->getValue() > $b->getFsb()->getValue()) ? -1 : 1;

                        //}
                        //return ($a->getName() < $b->getName()) ? -1 : 1;
                    } else {
                        return ($a->getPlatform() < $b->getPlatform()) ? -1 : 1;
                    }
                } else {
                    return ($a->getManufacturer() < $b->getManufacturer()) ? -1 : 1;
                }
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
        if ($this->name) {
            return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name . " (" . $this->partNumber . ")";
        }
        return $this->getManufacturer()->getShortNameIfExist() . " " . $this->partNumber;
    }
}
