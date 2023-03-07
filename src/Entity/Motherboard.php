<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\MotherboardRepository')]
class Motherboard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Dimensions is longer than {{ limit }} characters, try to make it shorter.')]
    private ?string $dimensions = null;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'motherboards', fetch: 'EAGER')]
    private $manufacturer;

    #[ORM\ManyToOne(targetEntity: Chipset::class, inversedBy: 'motherboards')]
    private $chipset;

    #[ORM\OneToMany(targetEntity: MotherboardMaxRam::class, mappedBy: 'motherboard', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $motherboardMaxRams;

    #[ORM\OneToMany(targetEntity: MotherboardBios::class, mappedBy: 'motherboard', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $motherboardBios;

    #[ORM\OneToMany(targetEntity: MotherboardExpansionSlot::class, mappedBy: 'motherboard', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $motherboardExpansionSlots;

    #[ORM\OneToMany(targetEntity: MotherboardIoPort::class, mappedBy: 'motherboard', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $motherboardIoPorts;

    #[ORM\ManyToMany(targetEntity: ProcessorPlatformType::class, inversedBy: 'motherboards')]
    private $processorPlatformTypes;

    #[ORM\ManyToMany(targetEntity: Processor::class, inversedBy: 'motherboards')]
    private $processors;

    #[ORM\ManyToMany(targetEntity: CpuSpeed::class, inversedBy: 'motherboards')]
    private $cpuSpeed;

    #[ORM\ManyToMany(targetEntity: CacheSize::class, inversedBy: 'motherboards')]
    private $cacheSize;

    #[ORM\ManyToMany(targetEntity: DramType::class, inversedBy: 'motherboards')]
    private $dramType;

    #[ORM\ManyToOne(targetEntity: FormFactor::class, inversedBy: 'motherboards')]
    private $formFactor;

    #[ORM\OneToMany(targetEntity: Manual::class, mappedBy: 'motherboard', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $manuals;

    #[ORM\ManyToMany(targetEntity: Coprocessor::class, inversedBy: 'motherboards')]
    private $coprocessors;

    #[ORM\OneToMany(targetEntity: MotherboardImage::class, mappedBy: 'motherboard', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $images;

    #[ORM\ManyToMany(targetEntity: KnownIssue::class, inversedBy: 'motherboards')]
    private $knownIssues;

    #[ORM\ManyToOne(targetEntity: MaxRam::class, inversedBy: 'motherboards')]
    private $maxVideoRam;

    #[ORM\Column(type: 'string', length: 2048, nullable: true)]
    #[Assert\Length(max: 2048, maxMessage: 'Notes is longer than {{ limit }} characters, try to make it shorter.')]
    private ?string $note = null;

    #[ORM\Column(type: 'datetime')]
    private $lastEdited;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\PositiveOrZero(message: 'Max CPU should be positive or zero')]
    #[Assert\LessThan(20, message: 'Max CPU should be below 20')]
    private ?int $maxCpu = null;

    #[ORM\OneToMany(targetEntity: MotherboardAlias::class, mappedBy: 'motherboard', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $motherboardAliases;

    #[ORM\ManyToMany(targetEntity: CpuSocket::class, inversedBy: 'motherboards')]
    private $cpuSockets;

    #[ORM\OneToMany(targetEntity: LargeFileMotherboard::class, mappedBy: 'motherboard', orphanRemoval: true, cascade: ['persist'])]
    private $drivers;

    #[ORM\OneToMany(targetEntity: MotherboardIdRedirection::class, mappedBy: 'destination', orphanRemoval: true, cascade: ['persist'])]
    private $redirections;

    #[ORM\ManyToMany(targetEntity: PSUConnector::class, inversedBy: 'motherboards')]
    private $psuConnectors;

    #[ORM\ManyToMany(targetEntity: ExpansionChip::class, inversedBy: 'motherboards')]
    private $expansionChips;

    #[ORM\Column(type: 'string', length: 80, unique: true)]
    #[Assert\Length(max: 80, maxMessage: 'Slug is longer than {{ limit }} characters, try to make it shorter.')]
    #[Assert\Regex('/^[a-z0-9-_.,]+$/i', message: 'Slug uses problematic characters. Only alphanumeric, ".", ",", "-" and "_" are allowed.')]
    private $slug;

    #[ORM\OneToMany(mappedBy: 'motherboard', targetEntity: MiscFile::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $miscFiles;

    public function __construct()
    {
        $this->motherboardMaxRams = new ArrayCollection();
        $this->motherboardBios = new ArrayCollection();
        $this->motherboardExpansionSlots = new ArrayCollection();
        $this->motherboardIoPorts = new ArrayCollection();
        $this->cpuSpeed = new ArrayCollection();
        $this->cacheSize = new ArrayCollection();
        $this->dramType = new ArrayCollection();
        $this->manuals = new ArrayCollection();
        $this->processors = new ArrayCollection();
        $this->coprocessors = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->knownIssues = new ArrayCollection();
        $this->lastEdited = new \DateTime('now');
        $this->motherboardAliases = new ArrayCollection();
        $this->cpuSockets = new ArrayCollection();
        $this->processorPlatformTypes = new ArrayCollection();
        $this->drivers = new ArrayCollection();
        $this->redirections = new ArrayCollection();
        $this->psuConnectors = new ArrayCollection();
        $this->expansionChips = new ArrayCollection();
        $this->miscFiles = new ArrayCollection();
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
        if ($this->manufacturer) {
            return $this->manufacturer->getShortNameIfExist();
        } else {
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
    public function getProcessorPlatformTypes(): Collection
    {
        return $this->processorPlatformTypes;
    }
    public function addProcessorPlatformType(ProcessorPlatformType $processorPlatformType): self
    {
        if (!$this->processorPlatformTypes->contains($processorPlatformType)) {
            $this->processorPlatformTypes[] = $processorPlatformType;
        }

        return $this;
    }
    public function removeProcessorPlatformType(ProcessorPlatformType $processorPlatformType): self
    {
        if ($this->processorPlatformTypes->contains($processorPlatformType)) {
            $this->processorPlatformTypes->removeElement($processorPlatformType);
        }

        return $this;
    }
    /**
     * @return Collection|Processor[]
     */
    public function getSortedProcessors(): Collection
    {
        $processors = array();
        foreach ($this->processors as $processor) {
            $processorsTmp = array();
            foreach ($processor->getChipAliases() as $alias) {
                if (
                    ($alias->getManufacturer() != $processor->getManufacturer())
                    &&
                    $alias->getName() != $processor->getName()
                ) {
                    $alreadyAdded = false;
                    foreach ($processorsTmp as $processorTmp) {
                        if (
                            ($alias->getManufacturer() == $processorTmp->getManufacturer())
                            &&
                            $alias->getName() == $processorTmp->getName()
                        ) {
                            $alreadyAdded = true;
                        }
                    }
                    if (!$alreadyAdded) {
                        $fakeCPU = clone $processor;
                        $fakeCPU->setName($alias->getName());
                        $fakeCPU->setManufacturer($alias->getManufacturer());
                        $fakeCPU->setPartNumber($alias->getPartNumber());
                        $processorsTmp[] = $fakeCPU;
                    }
                }
            }
            $processors = array_merge($processors, $processorsTmp);
        }
        $processors = array_merge($processors, $this->processors->toArray());
        return Processor::sort(new ArrayCollection($processors));
    }
    /**
     * @return Collection|Processor[]
     */
    public function getProcessors(): array
    {
        return $this->processors->toArray();
    }
    public function addProcessor(Processor $processor): self
    {
        if (!$this->processors->contains($processor)) {
            $this->processors[] = $processor;
        }

        return $this;
    }
    public function removeProcessor(Processor $processor): self
    {
        if ($this->processors->contains($processor)) {
            $this->processors->removeElement($processor);
        }

        return $this;
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

    public function getMaxVideoRam(): ?MaxRam
    {
        return $this->maxVideoRam;
    }
    public function setMaxVideoRam(?MaxRam $maxVideoRam): self
    {
        $this->maxVideoRam = $maxVideoRam;

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
    public function updateLastEdited()
    {
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
    /**
     * @return Collection|MotherboardAlias[]
     */
    public function getMotherboardAliases(): Collection
    {
        return $this->motherboardAliases;
    }
    public function addMotherboardAlias(MotherboardAlias $motherboardAlias): self
    {
        if (!$this->motherboardAliases->contains($motherboardAlias)) {
            $this->motherboardAliases[] = $motherboardAlias;
            $motherboardAlias->setMotherboard($this);
        }

        return $this;
    }
    public function removeMotherboardAlias(MotherboardAlias $motherboardAlias): self
    {
        if ($this->motherboardAliases->contains($motherboardAlias)) {
            $this->motherboardAliases->removeElement($motherboardAlias);
            // set the owning side to null (unless already changed)
            if ($motherboardAlias->getMotherboard() === $this) {
                $motherboardAlias->setMotherboard(null);
            }
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
            $cpuSocket->addMotherboard($this);
        }

        return $this;
    }
    public function removeCpuSocket(CpuSocket $cpuSocket): self
    {
        if ($this->cpuSockets->contains($cpuSocket)) {
            $this->cpuSockets->removeElement($cpuSocket);
            $cpuSocket->removeMotherboard($this);
        }

        return $this;
    }
    /**
     * @return Collection|LargeFileMotherboard[] | LargeFileExpansionChip[] | LargeFileChipset[]
     */
    public function getAllDrivers(): Collection
    {
        $drivers = array_merge($this->getDrivers()->toArray(), $this->getChipset()?->getDrivers()->toArray() ?? []);
        foreach ($this->getExpansionChips() as $expansionChip) {
            $drivers = array_merge($drivers, $expansionChip->getDrivers()->toArray());
        }
        return new ArrayCollection($drivers);
    }
    /**
     * @return Collection|LargeFileMotherboard[]
     */
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }
    public function addDriver(LargeFileMotherboard $driver): self
    {
        if (!$this->drivers->contains($driver)) {
            $this->drivers[] = $driver;
            $driver->setMotherboard($this);
        }

        return $this;
    }
    public function removeDriver(LargeFileMotherboard $driver): self
    {
        if ($this->drivers->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getMotherboard() === $this) {
                $driver->setMotherboard(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|MotherboardIdRedirection[]
     */
    public function getRedirections(): Collection
    {
        return $this->redirections;
    }
    public function addRedirection(MotherboardIdRedirection $redirection): self
    {
        if (!$this->redirections->contains($redirection)) {
            $this->redirections[] = $redirection;
            $redirection->setDestination($this);
        }

        return $this;
    }
    public function removeRedirection(MotherboardIdRedirection $redirection): self
    {
        if ($this->redirections->removeElement($redirection)) {
            // set the owning side to null (unless already changed)
            if ($redirection->getDestination() === $this) {
                $redirection->setDestination(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|PSUConnector[]
     */
    public function getPsuConnectors(): Collection
    {
        return $this->psuConnectors;
    }
    public function addPsuConnector(PSUConnector $psuConnector): self
    {
        if (!$this->psuConnectors->contains($psuConnector)) {
            $this->psuConnectors[] = $psuConnector;
            $psuConnector->addMotherboard($this);
        }

        return $this;
    }
    public function removePsuConnector(PSUConnector $psuConnector): self
    {
        if ($this->psuConnectors->removeElement($psuConnector)) {
            $psuConnector->removeMotherboard($this);
        }

        return $this;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function setSlug(string $slug): self
    {
        $this->slug = strtolower($slug);

        return $this;
    }
    /**
     * @return Collection|ExpansionChip[]
     */
    public function getExpansionChips(): Collection
    {
        return $this->expansionChips;
    }
    public function addExpansionChip(ExpansionChip $expansionChip): self
    {
        if (!$this->expansionChips->contains($expansionChip)) {
            $this->expansionChips[] = $expansionChip;
            $expansionChip->addMotherboard($this);
        }

        return $this;
    }
    public function removeExpansionChip(ExpansionChip $expansionChip): self
    {
        if ($this->expansionChips->removeElement($expansionChip)) {
            $expansionChip->removeMotherboard($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, MiscFile>
     */
    public function getMiscFiles(): Collection
    {
        return $this->miscFiles;
    }

    public function addMiscFile(MiscFile $miscFile): self
    {
        if (!$this->miscFiles->contains($miscFile)) {
            $this->miscFiles->add($miscFile);
            $miscFile->setMotherboard($this);
        }

        return $this;
    }

    public function removeMiscFile(MiscFile $miscFile): self
    {
        if ($this->miscFiles->removeElement($miscFile)) {
            // set the owning side to null (unless already changed)
            if ($miscFile->getMotherboard() === $this) {
                $miscFile->setMotherboard(null);
            }
        }

        return $this;
    }

    public function getPrettyTitle(): string
    {
        $strBuilder = "";
        $mfgData = $this->getManufacturer();
        if ($mfgData != null) {
            $strBuilder .= $mfgData->getShortNameIfExist();
        } else {
            $strBuilder .= "[Unknown]";
        }
        $strBuilder .= " " . $this->getName();
        return $strBuilder;
    }

    public function getMetaDescription(): string
    {
        $strBuilder = $this->getPrettyTitle();
        $strBuilder .= " is a motherboard based on the ";
        $chipData = $this->getChipset();
        if ($chipData != null) {
            $strBuilder .= $chipData->getPrettyTitle();
        } else {
            $strBuilder .= "[Unidentified]";
        }
        $strBuilder .= " chipset. Get specs, BIOS, documentation and more!";
        return $strBuilder;
    }
}
