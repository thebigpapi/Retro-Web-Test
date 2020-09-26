<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MotherboardRepository")
 */
class Motherboard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dimensions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manufacturer", inversedBy="motherboards")
     */
    private $manufacturer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chipset", inversedBy="motherboards")
     */
    private $chipset;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MotherboardMaxRam", mappedBy="motherboard", orphanRemoval=true, cascade={"persist"})
     */
    private $motherboardMaxRams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MotherboardBios", mappedBy="motherboard", orphanRemoval=true, cascade={"persist"})
     */
    private $motherboardBios;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MotherboardExpansionSlot", mappedBy="motherboard", orphanRemoval=true, cascade={"persist"})
     */
    private $motherboardExpansionSlots;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MotherboardIoPort", mappedBy="motherboard", orphanRemoval=true, cascade={"persist"})
     */
    private $motherboardIoPorts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProcessorPlatformType", inversedBy="motherboards")
     */
    private $processorPlatformType;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Processor", inversedBy="motherboards")
     */
    private $motherboardProcessor;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CpuSpeed", inversedBy="motherboards")
     */
    private $cpuSpeed;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CacheSize", inversedBy="motherboards")
     */
    private $cacheSize;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DramType", inversedBy="motherboards")
     */
    private $dramType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FormFactor", inversedBy="motherboards")
     */
    private $formFactor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Manual", mappedBy="motherboard", orphanRemoval=true, cascade={"persist"})
     */
    private $manuals;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Coprocessor", inversedBy="motherboards")
     */
    private $coprocessors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MotherboardImage", mappedBy="motherboard", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\KnownIssue", inversedBy="motherboards")
     */
    private $knownIssues;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VideoChipset", inversedBy="motherboards")
     */
    private $videoChipset;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MaxRam", inversedBy="motherboards")
     */
    private $maxVideoRam;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AudioChipset", inversedBy="motherboards")
     */
    private $audioChipset;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastEdited;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxCpu;


    public function __construct()
    {
        $this->motherboardProcessors = new ArrayCollection();
        $this->motherboardMaxRams = new ArrayCollection();
        $this->motherboardCpuSpeeds = new ArrayCollection();
        $this->motherboardBios = new ArrayCollection();
        $this->motherboardCacheSizes = new ArrayCollection();
        $this->motherboardDramTypes = new ArrayCollection();
        $this->motherboardExpansionSlots = new ArrayCollection();
        $this->motherboardIoPorts = new ArrayCollection();
        $this->motherboardProcessor = new ArrayCollection();
        $this->cpuSpeed = new ArrayCollection();
        $this->cacheSize = new ArrayCollection();
        $this->dramType = new ArrayCollection();
        $this->manuals = new ArrayCollection();
        $this->coprocessors = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->knownIssues = new ArrayCollection();
        $this->lastEdited = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(?string $dimensions): self
    {
        $this->dimensions = $dimensions;

        return $this;
    }
    
    public function getManufacturerShortNameIfExist(): ?string
    {
        if($this->manufacturer){
            return $this->manufacturer->getShortNameIfExist();
        }
        else{
            return 'Unknown';
        }
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getChipset(): ?Chipset
    {
        return $this->chipset;
    }

    public function setChipset(?Chipset $chipset): self
    {
        $this->chipset = $chipset;

        return $this;
    }


    /**
     * @return Collection|MotherboardMaxRam[]
     */
    public function getMotherboardMaxRams(): Collection
    {
        return $this->motherboardMaxRams;
    }

    public function addMotherboardMaxRam(MotherboardMaxRam $motherboardMaxRam): self
    {
        if (!$this->motherboardMaxRams->contains($motherboardMaxRam)) {
            $this->motherboardMaxRams[] = $motherboardMaxRam;
            $motherboardMaxRam->setMotherboard($this);
        }

        return $this;
    }

    public function addMaxRam(MaxRam $maxRam, $note): self
    {
        $mmr = new MotherboardMaxRam();
        $mmr->setMaxRam($maxRam);
        $mmr->setMotherboard($this);
        $mmr->setNote($note);
        
        return $this->addMotherboardMaxRam($mmr);
    }

    public function removeMotherboardMaxRam(MotherboardMaxRam $motherboardMaxRam): self
    {
        if ($this->motherboardMaxRams->contains($motherboardMaxRam)) {
            $this->motherboardMaxRams->removeElement($motherboardMaxRam);
            // set the owning side to null (unless already changed)
            if ($motherboardMaxRam->getMotherboard() === $this) {
                $motherboardMaxRam->setMotherboard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MotherboardBios[]
     */
    public function getMotherboardBios(): Collection
    {
        return $this->motherboardBios;
    }

    public function addMotherboardBios(MotherboardBios $motherboardBios): self
    {
        if (!$this->motherboardBios->contains($motherboardBios)) {
            $this->motherboardBios[] = $motherboardBios;
            $motherboardBios->setMotherboard($this);
        }

        return $this;
    }

    public function removeMotherboardBios(MotherboardBios $motherboardBios): self
    {
        if ($this->motherboardBios->contains($motherboardBios)) {
            $this->motherboardBios->removeElement($motherboardBios);
            // set the owning side to null (unless already changed)
            if ($motherboardBios->getMotherboard() === $this) {
                $motherboardBios->setMotherboard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MotherboardExpansionSlot[]
     */
    public function getMotherboardExpansionSlots(): Collection
    {
        return $this->motherboardExpansionSlots;
    }

    public function addMotherboardExpansionSlot(MotherboardExpansionSlot $motherboardExpansionSlot): self
    {
        if (!$this->motherboardExpansionSlots->contains($motherboardExpansionSlot)) {
            $this->motherboardExpansionSlots[] = $motherboardExpansionSlot;
            $motherboardExpansionSlot->setMotherboard($this);
        }

        return $this;
    }

    public function addExpansionSlot(ExpansionSlot $expansionSlot, int $count): self
    {
        $mes = new MotherboardExpansionSlot();
        $mes->setExpansionSlot($expansionSlot);
        $mes->setMotherboard($this);
        $mes->setCount($count);

        return $this->addMotherboardExpansionSlot($mes);
    }

    public function removeMotherboardExpansionSlot(MotherboardExpansionSlot $motherboardExpansionSlot): self
    {
        if ($this->motherboardExpansionSlots->contains($motherboardExpansionSlot)) {
            $this->motherboardExpansionSlots->removeElement($motherboardExpansionSlot);
            // set the owning side to null (unless already changed)
            if ($motherboardExpansionSlot->getMotherboard() === $this) {
                $motherboardExpansionSlot->setMotherboard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MotherboardIoPort[]
     */
    public function getMotherboardIoPorts(): Collection
    {
        return $this->motherboardIoPorts;
    }

    public function addMotherboardIoPort(MotherboardIoPort $motherboardIoPort): self
    {
        if (!$this->motherboardIoPorts->contains($motherboardIoPort)) {
            $this->motherboardIoPorts[] = $motherboardIoPort;
            $motherboardIoPort->setMotherboard($this);
        }

        return $this;
    }

    public function addIoPort(IoPort $ioPort, int $count): self
    {
        $mip = new MotherboardIoPort();
        $mip->setIoPort($ioPort);
        $mip->setMotherboard($this);
        $mip->setCount($count);
        
        return $this->addMotherboardIoPort($mip);
    }

    public function removeMotherboardIoPort(MotherboardIoPort $motherboardIoPort): self
    {
        if ($this->motherboardIoPorts->contains($motherboardIoPort)) {
            $this->motherboardIoPorts->removeElement($motherboardIoPort);
            // set the owning side to null (unless already changed)
            if ($motherboardIoPort->getMotherboard() === $this) {
                $motherboardIoPort->setMotherboard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProcessorPlatformType[]
     */
    public function getProcessorPlatformType(): ?ProcessorPlatformType
    {
        return $this->processorPlatformType;
    }

    public function setProcessorPlatformType(?ProcessorPlatformType $processorPlatformType): self
    {
        $this->processorPlatformType = $processorPlatformType;

        return $this;
    }

    /**
     * @return Collection|Processor[]
     */
    public function getMotherboardProcessor(): Collection
    {
        return $this->motherboardProcessor;
    }

    /**
     * @return Collection|CpuSpeed[]
     */
    public function getCpuSpeed(): Collection
    {
        return $this->cpuSpeed;
    }

    public function addCpuSpeed(CpuSpeed $cpuSpeed): self
    {
        if (!$this->cpuSpeed->contains($cpuSpeed)) {
            $this->cpuSpeed[] = $cpuSpeed;
        }

        return $this;
    }

    public function removeCpuSpeed(CpuSpeed $cpuSpeed): self
    {
        if ($this->cpuSpeed->contains($cpuSpeed)) {
            $this->cpuSpeed->removeElement($cpuSpeed);
        }

        return $this;
    }

    /**
     * @return Collection|CacheSize[]
     */
    public function getCacheSize(): Collection
    {
        return $this->cacheSize;
    }

    public function addCacheSize(CacheSize $cacheSize): self
    {
        if (!$this->cacheSize->contains($cacheSize)) {
            $this->cacheSize[] = $cacheSize;
        }

        return $this;
    }

    public function removeCacheSize(CacheSize $cacheSize): self
    {
        if ($this->cacheSize->contains($cacheSize)) {
            $this->cacheSize->removeElement($cacheSize);
        }

        return $this;
    }

    /**
     * @return Collection|DramType[]
     */
    public function getDramType(): Collection
    {
        return $this->dramType;
    }

    public function addDramType(DramType $dramType): self
    {
        if (!$this->dramType->contains($dramType)) {
            $this->dramType[] = $dramType;
        }

        return $this;
    }

    public function removeDramType(DramType $dramType): self
    {
        if ($this->dramType->contains($dramType)) {
            $this->dramType->removeElement($dramType);
        }

        return $this;
    }

    public function getFormFactor(): ?FormFactor
    {
        return $this->formFactor;
    }

    public function setFormFactor(?FormFactor $formFactor): self
    {
        $this->formFactor = $formFactor;

        return $this;
    }

    /**
     * @return Collection|Manual[]
     */
    public function getManuals(): Collection
    {
        return $this->manuals;
    }

    public function addManual(Manual $manual): self
    {
        if (!$this->manuals->contains($manual)) {
            $this->manuals[] = $manual;
            $manual->setMotherboard($this);
        }

        return $this;
    }

    public function removeManual(Manual $manual): self
    {
        if ($this->manuals->contains($manual)) {
            $this->manuals->removeElement($manual);
            // set the owning side to null (unless already changed)
            if ($manual->getMotherboard() === $this) {
                $manual->setMotherboard(null);
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
        }

        return $this;
    }

    public function removeCoprocessor(Coprocessor $coprocessor): self
    {
        if ($this->coprocessors->contains($coprocessor)) {
            $this->coprocessors->removeElement($coprocessor);
        }

        return $this;
    }

    /**
     * @return Collection|MotherboardImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(MotherboardImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setMotherboard($this);
        }

        return $this;
    }

    public function removeImage(MotherboardImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getMotherboard() === $this) {
                $image->setMotherboard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|KnownIssue[]
     */
    public function getKnownIssues(): Collection
    {
        return $this->knownIssues;
    }

    public function addKnownIssue(KnownIssue $knownIssue): self
    {
        if (!$this->knownIssues->contains($knownIssue)) {
            $this->knownIssues[] = $knownIssue;
        }

        return $this;
    }

    public function removeKnownIssue(KnownIssue $knownIssue): self
    {
        if ($this->knownIssues->contains($knownIssue)) {
            $this->knownIssues->removeElement($knownIssue);
        }

        return $this;
    }

    public function getVideoChipset(): ?VideoChipset
    {
        return $this->videoChipset;
    }

    public function setVideoChipset(?VideoChipset $videoChipset): self
    {
        $this->videoChipset = $videoChipset;

        return $this;
    }

    public function getMaxVideoRam(): ?MaxRam
    {
        return $this->maxVideoRam;
    }

    public function setMaxVideoRam(?MaxRam $maxVideoRam): self
    {
        $this->maxVideoRam = $maxVideoRam;

        return $this;
    }

    public function getAudioChipset(): ?AudioChipset
    {
        return $this->audioChipset;
    }

    public function setAudioChipset(?AudioChipset $audioChipset): self
    {
        $this->audioChipset = $audioChipset;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getLastEdited(): ?\DateTimeInterface
    {
        return $this->lastEdited;
    }

    public function setLastEdited(\DateTimeInterface $lastEdited): self
    {
        $this->lastEdited = $lastEdited;

        return $this;
    }

    public function updateLastEdited() {
        $this->lastEdited = new \DateTime('now');
    }

    public function getMaxCpu(): ?int
    {
        return $this->maxCpu;
    }

    public function setMaxCpu(?int $maxCpu): self
    {
        $this->maxCpu = $maxCpu;

        return $this;
    }

}