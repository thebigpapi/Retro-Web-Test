<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: 'App\Repository\MotherboardRepository')]
#[UniqueEntity('slug')]
class Motherboard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Dimensions is longer than {{ limit }} characters.')]
    private ?string $dimensions = null;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'motherboards')]
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

    #[ORM\OneToMany(targetEntity: MotherboardImage::class, mappedBy: 'motherboard', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $images;

    #[ORM\ManyToMany(targetEntity: KnownIssue::class, inversedBy: 'motherboards')]
    private $knownIssues;

    #[ORM\ManyToOne(targetEntity: MaxRam::class, inversedBy: 'motherboards')]
    private $maxVideoRam;

    #[ORM\Column(type: 'string', length: 2048, nullable: true)]
    #[Assert\Length(max: 2048, maxMessage: 'Notes is longer than {{ limit }} characters.')]
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
    #[Assert\Valid()]
    private $drivers;

    #[ORM\OneToMany(targetEntity: MotherboardIdRedirection::class, mappedBy: 'destination', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $redirections;

    #[ORM\ManyToMany(targetEntity: PSUConnector::class, inversedBy: 'motherboards')]
    private $psuConnectors;

    #[ORM\ManyToMany(targetEntity: ExpansionChip::class, inversedBy: 'motherboards')]
    private $expansionChips;

    #[ORM\Column(type: 'string', length: 80, unique: true)]
    #[Assert\Length(max: 80, maxMessage: 'Slug is longer than {{ limit }} characters.')]
    #[Assert\Regex('/^[a-z0-9-_.,]+$/i', message: 'Slug uses problematic characters. Only alphanumeric, ".", ",", "-" and "_" are allowed.')]
    private $slug;

    #[ORM\OneToMany(mappedBy: 'motherboard', targetEntity: MiscFile::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $miscFiles;

    #[ORM\OneToMany(mappedBy: 'motherboard', targetEntity: MotherboardMemoryConnector::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $motherboardMemoryConnectors;

    #[ORM\Column(nullable: true)]
    private ?int $score = null;

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
        $this->motherboardMemoryConnectors = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getFullName();
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
    public function getManufacturerName(): ?string
    {
        if ($this->manufacturer) {
            return $this->manufacturer->getName();
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
    public function getChipsetWithoutParts(): ?string
    {
        return $this->getChipset()?->getFullName();
    }
    public function setChipset(?Chipset $chipset): self
    {
        $this->chipset = $chipset;

        return $this;
    }
    public function isChipset(): bool
    {
        if(isset($this->chipset))
            return true;
        return false;
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
    public function getMotherboardBiosByVendor(): array
    {
        $biosByVendor = [];
        foreach ($this->motherboardBios as $bios) {
            $vendor = $bios->getManufacturer();
            $vendorName = $vendor !== null ? $vendor->getName() : "[Unknown]";
            if (!isset($biosByVendor[$vendorName])) {
                $biosByVendor[$vendorName] = [];
            }
            $biosByVendor[$vendorName][] = $bios;
        }
        return $biosByVendor;
    }
    public function addMotherboardBio(MotherboardBios $motherboardBios): self
    {
        if (!$this->motherboardBios->contains($motherboardBios)) {
            $this->motherboardBios[] = $motherboardBios;
            $motherboardBios->setMotherboard($this);
        }

        return $this;
    }
    public function removeMotherboardBio(MotherboardBios $motherboardBios): self
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
    public function isMotherboardBios(): bool
    {
        if(isset($this->motherboardBios))
            if(count($this->motherboardBios) > 0)
                return true;
        return false;
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
    public function addExpansionSlt(ExpansionSlot $expansionSlot, int $count): self
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
    public function getCompatibleFamilies(): Collection
    {
        $input = $this->processorPlatformTypes;
        $output = new ArrayCollection();
        foreach($this->processorPlatformTypes as $platform){
            $compatible = $platform->getCompatibleWith();
            if(!($compatible->isEmpty())){
                foreach($compatible as $c)
                    if(!($input->contains($c))){
                        $output->add($c);
                        $input->add($c);
                    }
            }
        }
        return $output;
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
    public function getChipDocs(): Collection
    {
        $docs = [];
        foreach ($this->getExpansionChips() as $expansionChip) {
            $docs = array_merge($docs, $expansionChip->getDocumentations()->toArray());
        }
        return new ArrayCollection($docs);
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
    public function isManuals(): bool
    {
        if(isset($this->manuals))
            if(count($this->manuals) > 0)
                return true;
        return false;
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
    public function isImages(): string
    {
        if(isset($this->images))
            $types = array(
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
            );
        foreach($this->images as $image){
            $types[$image->getMotherboardImageType()->getId()] += 1;
        }
        if(($types[1] || $types[5])){
            if(!($types[2] || $types[3] || $types[4]))
                return "Schema only";
            else return "Schema and photo";
        }
        else{
            if(!($types[2] || $types[3] || $types[4]))
                return "None";
            else return "Photo only";
        }
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
    public function addAlias(Manufacturer $manuf, string $name): self
    {
        $ma = new MotherboardAlias();
        $ma->setManufacturer($manuf);
        $ma->setMotherboard($this);
        $ma->setName($name);

        return $this->addMotherboardAlias($ma);
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
        $drivers = $this->getDrivers()->toArray();
        foreach ($this->getExpansionChips() as $expansionChip) {
            $drivers = array_merge($drivers, $expansionChip->getDrivers()->toArray());
        }
        $drivers = array_merge($drivers, $this->getChipset()?->getDrivers()->toArray() ?? []);
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
    public function isExpansionChips(): bool
    {
        if(isset($this->expansionChips))
            if(count($this->expansionChips) > 0)
                return true;
        return false;
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

    public function getFullName(): string
    {
        $strBuilder = "";
        $mfgData = $this->getManufacturer();
        if ($mfgData != null) {
            $strBuilder .= $mfgData->getName();
        } else {
            $strBuilder .= "[Unknown]";
        }
        $strBuilder .= " " . $this->getName();
        return $strBuilder;
    }

    public function getMetaDescription(): string
    {
        $strBuilder = $this->getFullName();
        $strBuilder .= " is a motherboard based on the ";
        $chipData = $this->getChipset();
        if ($chipData != null) {
            $strBuilder .= $chipData->getFullName();
        } else {
            $strBuilder .= "[Unidentified]";
        }
        $strBuilder .= " chipset. Get specs, BIOS, documentation and more!";
        return $strBuilder;
    }
    #[Assert\Callback]
    public function verifyIoPorts(ExecutionContextInterface $context): void
    {
        $arr = array();
        foreach($this->motherboardIoPorts as $item){
            $port = $item->getIoPort();
            if($item->getCount() == 0){
                $context->buildViolation('I/O port count should be above 0')
                    ->atPath('motherboardIoPorts')
                    ->addViolation();
            }
            if(in_array($port, $arr)){
                $context->buildViolation('Duplicate I/O port types are not allowed!')
                    ->atPath('motherboardIoPorts')
                    ->addViolation();
            }
            array_push($arr, $port);
        }
    }
    #[Assert\Callback]
    public function verifyExpansionSlots(ExecutionContextInterface $context): void
    {
        $arr = array();
        foreach($this->motherboardExpansionSlots as $item){
            $slot = $item->getExpansionSlot();
            if($item->getCount() == 0){
                $context->buildViolation('Expansion slot count should be above 0')
                    ->atPath('motherboardExpansionSlots')
                    ->addViolation();
            }
            if(in_array($slot, $arr)){
                $context->buildViolation('Duplicate expansion slot types are not allowed!')
                    ->atPath('motherboardExpansionSlots')
                    ->addViolation();
            }
            array_push($arr, $slot);
        }
    }
    #[Assert\Callback]
    public function verifyMaxRams(ExecutionContextInterface $context): void
    {
        $arr = array();
        foreach($this->motherboardMaxRams as $item){
            $val = $item->getMaxram();
            if(in_array($val, $arr)){
                $context->buildViolation('Duplicate RAM sizes are not allowed!')
                    ->atPath('motherboardMaxRams')
                    ->addViolation();
            }
            array_push($arr, $val);
        }
    }

    /**
     * @return Collection<int, MotherboardMemoryConnector>
     */
    public function getMotherboardMemoryConnectors(): Collection
    {
        return $this->motherboardMemoryConnectors;
    }

    public function addMotherboardMemoryConnector(MotherboardMemoryConnector $motherboardMemoryConnector): self
    {
        if (!$this->motherboardMemoryConnectors->contains($motherboardMemoryConnector)) {
            $this->motherboardMemoryConnectors->add($motherboardMemoryConnector);
            $motherboardMemoryConnector->setMotherboard($this);
        }

        return $this;
    }

    public function removeMotherboardMemoryConnector(MotherboardMemoryConnector $motherboardMemoryConnector): self
    {
        if ($this->motherboardMemoryConnectors->removeElement($motherboardMemoryConnector)) {
            // set the owning side to null (unless already changed)
            if ($motherboardMemoryConnector->getMotherboard() === $this) {
                $motherboardMemoryConnector->setMotherboard(null);
            }
        }

        return $this;
    }
    public function updateHashAll()
    {
        foreach($this->motherboardBios as $item){
            $item->updateHash();
        }
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getExpansionChipsScore(): int
    {
        if(!$this->expansionChips->isEmpty()){
            foreach($this->expansionChips as $chip)
                if($chip->getType()->getId() != 30)
                    return 5;
            return 2;
        }
        return 0;
    }

    public function getImagesScore(): int
    {
        $score = 0;
        $types = array();
        if(!$this->images->isEmpty()){
            foreach($this->images as $image){
                $typeId = $image->getMotherboardImageType()?->getId();
                if($typeId == 2)
                    $types[$typeId] = 7;
                else
                    $types[$typeId] = 2;
            }
            foreach($types as $t)
                $score += $t;
        }
        return $score;
    }

    public function getBiosScore(): int
    {
        $score = 0;
        $max = 0;
        if(!$this->motherboardBios->isEmpty()){
            foreach($this->motherboardBios as $bios){
                $max = 0;
                if($bios->getManufacturer() !== null)
                    $max += 3;
                if($bios->getPostString() != "")
                    $max += 6;
                if($bios->getFileName() != "")
                    $max += 6;
                if($score < $max)
                    $score = $max;
                if($score == 15)
                    return $score;
            }
        }
        return $score;
    }

    public function calculateScore(): int
    {
        $score = array();
        $final = 0;
        if(isset($this->manufacturer))
            $score['manufacturer'] = 5;
        if(isset($this->formFactor))
            $score['formFactor'] = 4;
        if(isset($this->dimensions))
            $score['dimensions'] = 1;
        if(isset($this->chipset))
            $score['chipset'] = 5;
        if(!$this->cpuSockets->isEmpty())
            $score['cpuSockets'] = 5;
        if(!$this->processorPlatformTypes->isEmpty())
            $score['cpuFamilies'] = 5;
        if(!$this->cpuSpeed->isEmpty())
            $score['fsb'] = 4;
        if(!$this->dramType->isEmpty())
            $score['ramTypes'] = 5;
        if(!$this->motherboardMaxRams->isEmpty())
            $score['maxram'] = 4;
        if(!$this->motherboardIoPorts->isEmpty())
            $score['ioPorts'] = 5;
        if(!$this->motherboardExpansionSlots->isEmpty())
            $score['expansionSlots'] = 5;
        if(!$this->psuConnectors->isEmpty())
            $score['powerConnectors'] = 5;
        $score['expansionChips'] = $this->getExpansionChipsScore(); // max:5
        // attachments
        if(!$this->manuals->isEmpty())
            $score['manuals'] = 10;
        if(!$this->getAllDrivers()->isEmpty())
            $score['drivers'] = 2;
        $score['bios'] = $this->getBiosScore(); //max: 15
        $score['images'] = $this->getImagesScore(); // max:15
        //dump($score);
        foreach($score as $s)
            $final += $s;
        //dump($final);
        return $final;
    }

    public function updateScore()
    {
        $newScore = $this->calculateScore();
        $oldScore = $this->getScore();
        if($newScore != $oldScore)
            $this->setScore($newScore);
    }

}
