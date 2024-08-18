<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ExpansionCardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpansionCardRepository::class)]
#[UniqueEntity('slug')]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['expansion_card:read:list', 'manufacturer:read:list']]),
        new Get(normalizationContext: ['groups' => ['expansion_card:read', 'manufacturer:read:list', 'expansion_card_type:read', 'known_issue:read', 'dram_type:read', 'max_ram:read']]),
        new Post(denormalizationContext: ['groups' => ['expansion_card:write']]),
        new Put(denormalizationContext: ['groups' => ['expansion_card:write']]),
        new Delete()
    ]
)]
class ExpansionCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['expansion_card:read', 'expansion_card:read:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    #[Groups(['expansion_card:read', 'expansion_card:read:list', 'expansion_card:write'])]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Chip::class, inversedBy: 'expansionCards')]
    #[Groups(['expansion_card:read'])]
    private Collection $chips;

    #[ORM\Column(length: 4096, nullable: true)]
    #[Assert\Length(max: 4096, maxMessage: 'Description is longer than {{ limit }} characters.')]
    #[Groups(['expansion_card:read', 'expansion_card:write'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: LargeFileExpansionCard::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    #[Groups(['expansion_card:read'])]
    private Collection $drivers;

    #[ORM\OneToMany(targetEntity: ExpansionCardDocumentation::class, mappedBy: 'expansionCard', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    #[Groups(['expansion_card:read'])]
    protected $documentations;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardImage::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    #[Groups(['expansion_card:read'])]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: ExpansionCardType::class, inversedBy: 'expansionCards')]
    #[Groups(['expansion_card:read'])]
    private Collection $type;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardAlias::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    #[Groups(['expansion_card:read'])]
    private Collection $expansionCardAliases;

    #[ORM\ManyToOne(inversedBy: 'expansionCards')]
    #[Groups(['expansion_card:read', 'expansion_card:read:list'])]
    private ?Manufacturer $manufacturer = null;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardBios::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    #[Groups(['expansion_card:read'])]
    private Collection $expansionCardBios;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['expansion_card:read', 'expansion_card:read:list'])]
    private $lastEdited;

    #[ORM\Column(type: 'string', length: 80, unique: true)]
    #[Assert\Length(max: 80, maxMessage: 'Slug is longer than {{ limit }} characters.')]
    #[Assert\Regex('/^[a-z0-9-_.,]+$/i', message: 'Slug uses problematic characters. Only alphanumeric, ".", ",", "-" and "_" are allowed.')]
    #[Groups(['expansion_card:read', 'expansion_card:read:list', 'expansion_card:write'])]
    private $slug;

    #[ORM\OneToMany(mappedBy: 'destination', targetEntity: ExpansionCardIdRedirection::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    #[Groups(['expansion_card:read'])]
    private Collection $redirections;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardMemoryConnector::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    #[Groups(['expansion_card:read'])]
    private Collection $expansionCardMemoryConnectors;

    #[ORM\ManyToMany(targetEntity: DramType::class, inversedBy: 'expansionCards')]
    #[Groups(['expansion_card:read'])]
    private Collection $dramType;

    #[ORM\ManyToMany(targetEntity: MaxRam::class, inversedBy: 'expansionCards')]
    #[Groups(['expansion_card:read'])]
    private Collection $ramSize;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardIoPort::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    #[Groups(['expansion_card:read'])]
    private Collection $ioPorts;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message: 'Interface cannot be blank'
    )]
    #[Groups(['expansion_card:read'])]
    private ?ExpansionSlotInterface $expansionSlotInterface = null;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: PciDeviceId::class,  orphanRemoval: true, cascade: ['persist'])]
    private Collection $pciDevs;
    #[ORM\Column(type: Types::JSON, options: ['jsonb' => true])]
    #[Groups(['expansion_card:read', 'expansion_card:write'])]
    private array $miscSpecs = [];

    #[ORM\ManyToMany(targetEntity: KnownIssue::class, inversedBy: 'expansionCards')]
    #[Groups(['expansion_card:read'])]
    private Collection $knownIssues;

    #[Assert\Positive(message: "Width should be above 0")]
    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Groups(['expansion_card:read', 'expansion_card:write'])]
    private ?int $width = null;

    #[Assert\Positive(message: "Height should be above 0")]
    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Groups(['expansion_card:read', 'expansion_card:write'])]
    private ?int $height = null;

    #[Assert\Positive(message: "Slot height should be greater than 0")]
    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Groups(['expansion_card:read', 'expansion_card:write'])]
    private ?int $slotCount = null;

    #[Assert\Positive(message: "Length should be above 0")]
    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Groups(['expansion_card:read', 'expansion_card:write'])]
    private ?int $length = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCards')]
    #[Groups(['expansion_card:read'])]
    private ?ExpansionSlotInterfaceSignal $expansionSlotInterfaceSignal = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['expansion_card:read', 'expansion_card:write'])]
    private ?string $fccid = null;

    #[ORM\ManyToMany(targetEntity: ExpansionSlotSignal::class, inversedBy: 'expansionCards')]
    #[Groups(['expansion_card:read'])]
    private Collection $expansionSlotSignals;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardPowerConnector::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    #[Groups(['expansion_card:read'])]
    private Collection $expansionCardPowerConnectors;

    public function __construct()
    {
        $this->chips = new ArrayCollection();
        $this->documentations = new ArrayCollection();
        $this->drivers = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->type = new ArrayCollection();
        $this->expansionCardAliases = new ArrayCollection();
        $this->expansionCardBios = new ArrayCollection();
        $this->lastEdited = new \DateTime('now');
        $this->redirections = new ArrayCollection();
        $this->expansionCardMemoryConnectors = new ArrayCollection();
        $this->dramType = new ArrayCollection();
        $this->ramSize = new ArrayCollection();
        $this->ioPorts = new ArrayCollection();
        $this->pciDevs = new ArrayCollection();
        $this->knownIssues = new ArrayCollection();
        $this->expansionSlotSignals = new ArrayCollection();
        $this->expansionCardPowerConnectors = new ArrayCollection();
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

    public function setName(string $name): static
    {
        $this->name = $name;

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
    public function getManufacturerName(): ?string
    {
        if ($this->manufacturer) {
            return $this->manufacturer->getName();
        } else {
            return 'Unknown';
        }
    }

    /**
     * @return Collection<int, Chip>
     */
    public function getChips(): Collection
    {
        return $this->chips;
    }

    public function addChip(Chip $chip): static
    {
        if (!$this->chips->contains($chip)) {
            $this->chips->add($chip);
        }

        return $this;
    }

    public function removeChip(Chip $chip): static
    {
        $this->chips->removeElement($chip);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, LargeFileExpansionCard>
     */
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }
    public function getAllDrivers(): Collection
    {
        $drivers = $this->getDrivers()->toArray();
        foreach ($this->getChips() as $chip) {
            if (get_class($chip) !== Chip::class) {
                continue;
            }
            $drivers = array_merge($drivers, $chip->getDrivers()->toArray());
        }
        return new ArrayCollection($drivers);
    }

    public function addDriver(LargeFileExpansionCard $driver): static
    {
        if (!$this->drivers->contains($driver)) {
            $this->drivers->add($driver);
            $driver->setExpansionCard($this);
        }

        return $this;
    }

    public function removeDriver(LargeFileExpansionCard $driver): static
    {
        if ($this->drivers->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getExpansionCard() === $this) {
                $driver->setExpansionCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCardImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ExpansionCardImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setExpansionCard($this);
        }

        return $this;
    }

    public function removeImage(ExpansionCardImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getExpansionCard() === $this) {
                $image->setExpansionCard(null);
            }
        }

        return $this;
    }
    public function isExpansionCardImage(): string
    {
        if(isset($this->images))
            $types = array(
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
            );
        foreach($this->images as $image){
            $types[(int)$image->getType()] += 1;
        }
        if(($types[1] || $types[5])){
            if(!($types[2] || $types[3] || $types[4] || $types[6]))
                return "Schema only";
            else return "Schema and photo";
        }
        else{
            if(!($types[2] || $types[3] || $types[4] || $types[6]))
                return "None";
            else return "Photo only";
        }
    }
    /**
     * @return Collection|ExpansionCardDocumentation[]
     */
    public function getDocumentations(): Collection
    {
        return $this->documentations;
    }
    public function getChipDocs(): Collection
    {
        $docs = [];
        foreach ($this->getChips() as $chip) {
            $docs = array_merge($docs, $chip->getDocumentations()->toArray());
        }
        return new ArrayCollection($docs);
    }
    public function addDocumentation(ExpansionCardDocumentation $documentation): self
    {
        if (!$this->documentations->contains($documentation)) {
            $this->documentations[] = $documentation;
            $documentation->setExpansionCard($this);
        }

        return $this;
    }
    public function removeDocumentation(ExpansionCardDocumentation $documentation): self
    {
        if ($this->documentations->contains($documentation)) {
            $this->documentations->removeElement($documentation);
            // set the owning side to null (unless already changed)
            if ($documentation->getExpansionCard() === $this) {
                $documentation->setExpansionCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCardType>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(ExpansionCardType $type): static
    {
        if (!$this->type->contains($type)) {
            $this->type->add($type);
        }

        return $this;
    }

    public function removeType(ExpansionCardType $type): static
    {
        $this->type->removeElement($type);

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCardAlias>
     */
    public function getExpansionCardAliases(): Collection
    {
        return $this->expansionCardAliases;
    }

    public function addExpansionCardAlias(ExpansionCardAlias $expansionCardAlias): static
    {
        if (!$this->expansionCardAliases->contains($expansionCardAlias)) {
            $this->expansionCardAliases->add($expansionCardAlias);
            $expansionCardAlias->setExpansionCard($this);
        }

        return $this;
    }

    public function removeExpansionCardAlias(ExpansionCardAlias $expansionCardAlias): static
    {
        if ($this->expansionCardAliases->removeElement($expansionCardAlias)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardAlias->getExpansionCard() === $this) {
                $expansionCardAlias->setExpansionCard(null);
            }
        }

        return $this;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): static
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCardBios>
     */
    public function getExpansionCardBios(): Collection
    {
        return $this->expansionCardBios;
    }

    public function addExpansionCardBio(ExpansionCardBios $expansionCardBio): static
    {
        if (!$this->expansionCardBios->contains($expansionCardBio)) {
            $this->expansionCardBios->add($expansionCardBio);
            $expansionCardBio->setExpansionCard($this);
        }

        return $this;
    }

    public function removeExpansionCardBio(ExpansionCardBios $expansionCardBio): static
    {
        if ($this->expansionCardBios->removeElement($expansionCardBio)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardBio->getExpansionCard() === $this) {
                $expansionCardBio->setExpansionCard(null);
            }
        }

        return $this;
    }
    public function isExpansionCardBios(): bool
    {
        if(isset($this->expansionCardBios))
            if(count($this->expansionCardBios) > 0)
                return true;
        return false;
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
     * @return Collection<int, ExpansionCardIdRedirection>
     */
    public function getRedirections(): Collection
    {
        return $this->redirections;
    }

    public function addRedirection(ExpansionCardIdRedirection $redirection): static
    {
        if (!$this->redirections->contains($redirection)) {
            $this->redirections[] = $redirection;
            $redirection->setDestination($this);
        }

        return $this;
    }

    public function removeRedirection(ExpansionCardIdRedirection $redirection): static
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
     * @return Collection<int, ExpansionCardMemoryConnector>
     */
    public function getExpansionCardMemoryConnectors(): Collection
    {
        return $this->expansionCardMemoryConnectors;
    }

    public function addExpansionCardMemoryConnector(ExpansionCardMemoryConnector $expansionCardMemoryConnector): static
    {
        if (!$this->expansionCardMemoryConnectors->contains($expansionCardMemoryConnector)) {
            $this->expansionCardMemoryConnectors->add($expansionCardMemoryConnector);
            $expansionCardMemoryConnector->setExpansionCard($this);
        }

        return $this;
    }

    public function removeExpansionCardMemoryConnector(ExpansionCardMemoryConnector $expansionCardMemoryConnector): static
    {
        if ($this->expansionCardMemoryConnectors->removeElement($expansionCardMemoryConnector)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardMemoryConnector->getExpansionCard() === $this) {
                $expansionCardMemoryConnector->setExpansionCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DramType>
     */
    public function getDramType(): Collection
    {
        return $this->dramType;
    }

    public function addDramType(DramType $dramType): static
    {
        if (!$this->dramType->contains($dramType)) {
            $this->dramType->add($dramType);
        }

        return $this;
    }

    public function removeDramType(DramType $dramType): static
    {
        $this->dramType->removeElement($dramType);

        return $this;
    }

    /**
     * @return Collection<int, MaxRam>
     */
    public function getRamSize(): Collection
    {
        return $this->ramSize;
    }

    public function addRamSize(MaxRam $ramSize): static
    {
        if (!$this->ramSize->contains($ramSize)) {
            $this->ramSize->add($ramSize);
        }

        return $this;
    }

    public function removeRamSize(MaxRam $ramSize): static
    {
        $this->ramSize->removeElement($ramSize);

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCardIoPort>
     */
    public function getIoPorts(): Collection
    {
        return $this->ioPorts;
    }

    public function addIoPort(ExpansionCardIoPort $expansionCardIoPort): static
    {
        if (!$this->ioPorts->contains($expansionCardIoPort)) {
            $this->ioPorts->add($expansionCardIoPort);
            $expansionCardIoPort->setExpansionCard($this);
        }

        return $this;
    }

    public function removeIoPort(ExpansionCardIoPort $expansionCardIoPort): static
    {
        if ($this->ioPorts->removeElement($expansionCardIoPort)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardIoPort->getExpansionCard() === $this) {
                $expansionCardIoPort->setExpansionCard(null);
            }
        }

        return $this;
    }

    public function getExpansionSlotInterface(): ?ExpansionSlotInterface
    {
        return $this->expansionSlotInterface;
    }

    public function setExpansionSlotInterface(?ExpansionSlotInterface $expansionSlotInterface): static
    {
        $this->expansionSlotInterface = $expansionSlotInterface;

        return $this;
    }

    /**
     * @return Collection<int, PciDeviceId>
     */
    public function getPciDevs(): Collection
    {
        return $this->pciDevs;
    }

    public function addPciDev(PciDeviceId $pciDev): static
    {
        if (!$this->pciDevs->contains($pciDev)) {
            $this->pciDevs->add($pciDev);
            $pciDev->setExpansionCard($this);
        }

        return $this;
    }

    public function removePciDev(PciDeviceId $pciDev): static
    {
        if ($this->pciDevs->removeElement($pciDev)) {
            // set the owning side to null (unless already changed)
            if ($pciDev->getExpansionCard() === $this) {
                $pciDev->setExpansionCard(null);
            }
        }
        return $this;
    }

    public function getMiscSpecs(): array
    {
        return $this->miscSpecs;
    }
    public function getMiscSpecsFormatted(): array
    {
        $output = [];
        foreach($this->miscSpecs as $spec){
            $new = str_replace("\"","",json_encode($spec));
            $new = str_replace(":",": ",$new);
            array_push($output, substr($new, 1, -1));
        }
        return $output;
    }
    public function getSimpleMiscSpecs(): array
    {
        $output = [];
        foreach($this->miscSpecs as $key => $value){
            if(!is_array($value))
                $output[$key] = $value;
        }
        return $output;
    }
    public function getTableMiscSpecs(): array
    {
        $output = [];
        foreach($this->miscSpecs as $key => $value){
            if(is_array($value))
                $output[$key] = $value;
        }
        return $this->sortMiscSpecTables($output);
    }
    function sortMiscSpecTables($arrays) {
        $lengths = array_map('count', $arrays);
        arsort($lengths);
        $return = array();
        foreach(array_keys($lengths) as $k)
            $return[$k] = $arrays[$k];
        return $return;
    }

    public function setMiscSpecs(array $miscSpecs): static
    {
        $this->miscSpecs = $miscSpecs;

        return $this;
    }

    /**
     * @return Collection<int, KnownIssue>
     */
    public function getKnownIssues(): Collection
    {
        return $this->knownIssues;
    }

    public function addKnownIssue(KnownIssue $knownIssue): static
    {
        if (!$this->knownIssues->contains($knownIssue)) {
            $this->knownIssues->add($knownIssue);
        }

        return $this;
    }

    public function removeKnownIssue(KnownIssue $knownIssue): static
    {
        $this->knownIssues->removeElement($knownIssue);

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getSlotCount(): ?int
    {
        return $this->slotCount;
    }

    public function setSlotCount(?int $slotCount): static
    {
        $this->slotCount = $slotCount;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): static
    {
        $this->length = $length;

        return $this;
    }

    public function getExpansionSlotInterfaceSignal(): ?ExpansionSlotInterfaceSignal
    {
        return $this->expansionSlotInterfaceSignal;
    }

    public function setExpansionSlotInterfaceSignal(?ExpansionSlotInterfaceSignal $expansionSlotInterfaceSignal): static
    {
        $this->expansionSlotInterfaceSignal = $expansionSlotInterfaceSignal;

        return $this;
    }

    public function getFccid(): ?string
    {
        return $this->fccid;
    }

    public function setFccid(?string $fccid): static
    {
        $this->fccid = $fccid;

        return $this;
    }

    /**
     * @return Collection<int, ExpansionSlotSignal>
     */
    public function getExpansionSlotSignals(): Collection
    {
        return $this->expansionSlotSignals;
    }

    public function addExpansionSlotSignal(ExpansionSlotSignal $expansionSlotSignal): static
    {
        if (!$this->expansionSlotSignals->contains($expansionSlotSignal)) {
            $this->expansionSlotSignals->add($expansionSlotSignal);
        }

        return $this;
    }

    public function removeExpansionSlotSignal(ExpansionSlotSignal $expansionSlotSignal): static
    {
        $this->expansionSlotSignals->removeElement($expansionSlotSignal);

        return $this;
    }
    public function updateHashAll()
    {
        foreach($this->expansionCardBios as $item){
            $item->updateHash();
        }
    }

    /**
     * @return Collection<int, ExpansionCardPowerConnector>
     */
    public function getExpansionCardPowerConnectors(): Collection
    {
        return $this->expansionCardPowerConnectors;
    }

    public function addExpansionCardPowerConnector(ExpansionCardPowerConnector $expansionCardPowerConnector): static
    {
        if (!$this->expansionCardPowerConnectors->contains($expansionCardPowerConnector)) {
            $this->expansionCardPowerConnectors->add($expansionCardPowerConnector);
            $expansionCardPowerConnector->setExpansionCard($this);
        }

        return $this;
    }

    public function removeExpansionCardPowerConnector(ExpansionCardPowerConnector $expansionCardPowerConnector): static
    {
        if ($this->expansionCardPowerConnectors->removeElement($expansionCardPowerConnector)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardPowerConnector->getExpansionCard() === $this) {
                $expansionCardPowerConnector->setExpansionCard(null);
            }
        }

        return $this;
    }

    public function getChipsWithDrivers(): array
    {
        $driverChips = [];
        foreach($this->chips as $chip){
            if (get_class($chip) !== Chip::class) {
                continue;
            }
            if(!$chip->getDrivers()->isEmpty())
                array_push($driverChips, $chip->getFullName());
        }
        return $driverChips;
    }
}
