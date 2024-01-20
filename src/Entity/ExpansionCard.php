<?php

namespace App\Entity;

use App\Repository\ExpansionCardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Rector\NodeCollector\ValueObject\ArrayCallable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpansionCardRepository::class)]
#[UniqueEntity('slug')]
class ExpansionCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: ExpansionChip::class, inversedBy: 'expansionCards')]
    private Collection $expansionChips;

    #[ORM\ManyToMany(targetEntity: PSUConnector::class, inversedBy: 'expansionCards')]
    private Collection $powerConnectors;

    #[ORM\Column(length: 4096, nullable: true)]
    #[Assert\Length(max: 4096, maxMessage: 'Description is longer than {{ limit }} characters, try to make it shorter.')]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: LargeFileExpansionCard::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $drivers;

    #[ORM\OneToMany(targetEntity: ExpansionCardDocumentation::class, mappedBy: 'expansionCard', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    protected $documentations;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardImage::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: ExpansionCardType::class, inversedBy: 'expansionCards')]
    private Collection $type;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardAlias::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $expansionCardAliases;

    #[ORM\ManyToOne(inversedBy: 'expansionCards')]
    private ?Manufacturer $manufacturer = null;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardBios::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $expansionCardBios;

    #[ORM\Column(type: 'datetime')]
    private $lastEdited;

    #[ORM\Column(type: 'string', length: 80, unique: true)]
    #[Assert\Length(max: 80, maxMessage: 'Slug is longer than {{ limit }} characters, try to make it shorter.')]
    #[Assert\Regex('/^[a-z0-9-_.,]+$/i', message: 'Slug uses problematic characters. Only alphanumeric, ".", ",", "-" and "_" are allowed.')]
    private $slug;

    #[ORM\OneToMany(mappedBy: 'destination', targetEntity: ExpansionCardIdRedirection::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $redirections;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardMemoryConnector::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $expansionCardMemoryConnectors;

    #[ORM\ManyToMany(targetEntity: DramType::class, inversedBy: 'expansionCards')]
    private Collection $dramType;

    #[ORM\ManyToMany(targetEntity: MaxRam::class, inversedBy: 'expansionCards')]
    private Collection $ramSize;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardIoPort::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $ioPorts;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message: 'Interface cannot be blank'
    )]
    private ?ExpansionSlotInterface $expansionSlotInterface = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCards')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message: 'Signal cannot be blank'
    )]
    private ?ExpansionSlotSignal $expansionSlotSignal = null;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: PciDeviceId::class,  orphanRemoval: true, cascade: ['persist'])]
    private Collection $pciDevs;
    #[ORM\Column]
    private array $miscSpecs = [];

    #[ORM\ManyToMany(targetEntity: KnownIssue::class, inversedBy: 'expansionCards')]
    private Collection $knownIssues;

    public function __construct()
    {
        $this->expansionChips = new ArrayCollection();
        $this->powerConnectors = new ArrayCollection();
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
    public function getPrettyTitle(): string
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

    /**
     * @return Collection<int, ExpansionChip>
     */
    public function getExpansionChips(): Collection
    {
        return $this->expansionChips;
    }

    public function addExpansionChip(ExpansionChip $expansionChip): static
    {
        if (!$this->expansionChips->contains($expansionChip)) {
            $this->expansionChips->add($expansionChip);
        }

        return $this;
    }

    public function removeExpansionChip(ExpansionChip $expansionChip): static
    {
        $this->expansionChips->removeElement($expansionChip);

        return $this;
    }

    /**
     * @return Collection<int, PSUConnector>
     */
    public function getPowerConnectors(): Collection
    {
        return $this->powerConnectors;
    }

    public function addPowerConnector(PSUConnector $powerConnector): static
    {
        if (!$this->powerConnectors->contains($powerConnector)) {
            $this->powerConnectors->add($powerConnector);
        }

        return $this;
    }

    public function removePowerConnector(PSUConnector $powerConnector): static
    {
        $this->powerConnectors->removeElement($powerConnector);

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
        foreach ($this->getExpansionChips() as $expansionChip) {
            $drivers = array_merge($drivers, $expansionChip->getDrivers()->toArray());
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
            );
        foreach($this->images as $image){
            $types[(int)$image->getType()] += 1;
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
     * @return Collection|ExpansionCardDocumentation[]
     */
    public function getDocumentations(): Collection
    {
        return $this->documentations;
    }
    public function getChipDocs(): Collection
    {
        $docs = [];
        foreach ($this->getExpansionChips() as $expansionChip) {
            $docs = array_merge($docs, $expansionChip->getDocumentations()->toArray());
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

    public function getExpansionSlotSignal(): ?ExpansionSlotSignal
    {
        return $this->expansionSlotSignal;
    }

    public function setExpansionSlotSignal(?ExpansionSlotSignal $expansionSlotSignal): static
    {
        $this->expansionSlotSignal = $expansionSlotSignal;

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
}
