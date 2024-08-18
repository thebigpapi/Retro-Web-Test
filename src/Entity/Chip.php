<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ChipRepository')]
#[ORM\InheritanceType('JOINED')]
abstract class Chip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 32, maxMessage: 'String is longer than {{ limit }} characters.')]
    protected $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'String is longer than {{ limit }} characters.')]
    protected $partNumber;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'chips', fetch: 'EAGER')]
    protected $manufacturer;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'chips')]
    private Collection $motherboards;

    #[ORM\ManyToMany(targetEntity: Chipset::class, mappedBy: 'chips')]
    private Collection $chipsets;

    #[ORM\OneToMany(targetEntity: LargeFileExpansionChip::class, mappedBy: 'chip', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $drivers;

    #[ORM\Column(length: 8192, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: ExpansionCard::class, mappedBy: 'chips')]
    private Collection $expansionCards;

    #[ORM\OneToMany(mappedBy: 'chip', targetEntity: ExpansionChipBios::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $chipBios;

    #[ORM\OneToMany(targetEntity: ChipDocumentation::class, mappedBy: 'chip', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    protected Collection $documentations;

    #[ORM\ManyToMany(targetEntity: CpuSocket::class, inversedBy: 'chips')]
    #[Assert\Valid()]
    private Collection $sockets;

    #[ORM\ManyToOne(targetEntity: ProcessorPlatformType::class, inversedBy: 'chips')]
    protected $family;

    #[ORM\Column(type: 'float', nullable: true)]
    private $tdp;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $processNode;

    #[ORM\OneToMany(targetEntity: ChipAlias::class, mappedBy: 'chip', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $chipAliases;

    #[ORM\OneToMany(targetEntity: ChipImage::class, mappedBy: 'chip', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'chip', targetEntity: PciDeviceId::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $pciDevs;

    #[ORM\Column(type: 'datetime')]
    private $lastEdited;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotBlank(message: 'Sort position cannot be blank')]
    #[Assert\Positive(message: "Sort position should be above 0")]
    private ?int $sort = null;

    #[ORM\ManyToOne(targetEntity: ExpansionChipType::class, inversedBy: 'chips')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\Column(type: Types::JSON, options: ['jsonb' => true])]
    private ?array $miscSpecs = [];

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->chipsets = new ArrayCollection();
        $this->drivers = new ArrayCollection();
        $this->expansionCards = new ArrayCollection();
        $this->chipBios = new ArrayCollection();
        $this->sockets = new ArrayCollection();
        $this->chipAliases = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->pciDevs = new ArrayCollection();
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
    public function getPartNumber(): ?string
    {
        return $this->partNumber;
    }
    public function setPartNumber(string $partNumber): self
    {
        $this->partNumber = $partNumber;

        return $this;
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
            $motherboard->addChip($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            $motherboard->removeChip($this);
        }

        return $this;
    }

    /**
     * @return Collection|Chipset[]
     */
    public function getChipsets(): Collection
    {
        return $this->chipsets;
    }
    public function addChipset(Chipset $chipset): self
    {
        if (!$this->chipsets->contains($chipset)) {
            $this->chipsets[] = $chipset;
            $chipset->addChip($this);
        }

        return $this;
    }
    public function removeChipset(Chipset $chipset): self
    {
        if ($this->chipsets->contains($chipset)) {
            $this->chipsets->removeElement($chipset);
            // set the owning side to null (unless already changed)
            if ($chipset->getChips()->contains($this)) {
                $chipset->removeChip($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LargeFileExpansionChip[]
     */
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }
    public function addDriver(LargeFileExpansionChip $driver): self
    {
        if (!$this->drivers->contains($driver)) {
            $this->drivers[] = $driver;
            $driver->setChip($this);
        }

        return $this;
    }
    public function removeDriver(LargeFileExpansionChip $driver): self
    {
        if ($this->drivers->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getChip() === $this) {
                $driver->setChip(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ExpansionChipBios>
     */
    public function getChipBios(): Collection
    {
        return $this->chipBios;
    }

    public function addChipBio(ExpansionChipBios $chipBio): static
    {
        if (!$this->chipBios->contains($chipBio)) {
            $this->chipBios->add($chipBio);
            $chipBio->setChip($this);
        }

        return $this;
    }

    public function removeChipBio(ExpansionChipBios $chipBio): static
    {
        if ($this->chipBios->removeElement($chipBio)) {
            // set the owning side to null (unless already changed)
            if ($chipBio->getChip() === $this) {
                $chipBio->setChip(null);
            }
        }

        return $this;
    }
    public function isChipBios(): bool
    {
        if(isset($this->chipBios))
            if(count($this->chipBios) > 0)
                return true;
        return false;
    }

    /**
     * @return Collection|CpuSocket[]
     */
    public function getSockets(): Collection
    {
        return $this->sockets;
    }
    public function addSocket(CpuSocket $socket): self
    {
        if (!$this->sockets->contains($socket)) {
            $this->sockets[] = $socket;
        }

        return $this;
    }
    public function removeSocket(CpuSocket $socket): self
    {
        if ($this->sockets->contains($socket)) {
            $this->sockets->removeElement($socket);
        }

        return $this;
    }

    public function getFamily(): ?ProcessorPlatformType
    {
        return $this->family;
    }
    public function setFamily(?ProcessorPlatformType $family): self
    {
        $this->family = $family;

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
        return $this->processNode;
    }
    public function setProcessNode(?int $processNode): self
    {
        $this->processNode = $processNode;

        return $this;
    }

    public function getProcessNodeWithValue(): string
    {
        return $this->processNode ? $this->processNode . "nm" : "";
    }
    public function getTdpWithValue(): string
    {
        return $this->tdp ? $this->tdp . "W" : "";
    }

    public function getNameWithoutManuf(): string
    {
        if ($this->name) {
            return $this->partNumber . " (" . $this->name . ")";
        }
        return $this->partNumber;
    }
    /**
     * @return Collection|ChipAlias[]
     */
    public function getChipAliases(): Collection
    {

        return $this->chipAliases;
    }
    public function addChipAlias(ChipAlias $chipAlias): self
    {
        if (!$this->chipAliases->contains($chipAlias)) {
            $this->chipAliases[] = $chipAlias;
            $chipAlias->setChip($this);
        }

        return $this;
    }
    public function removeChipAlias(ChipAlias $chipAlias): self
    {
        if ($this->chipAliases->contains($chipAlias)) {
            $this->chipAliases->removeElement($chipAlias);
            // set the owning side to null (unless already changed)
            if ($chipAlias->getChip() === $this) {
                $chipAlias->setChip(null);
            }
        }

        return $this;
    }
    public function addAlias(Manufacturer $manuf, ?string $name, string $partNumber): self
    {
        $cha = new ChipAlias();
        $cha->setManufacturer($manuf);
        $cha->setChip($this);
        $cha->setName($name);
        $cha->setPartNumber($partNumber);

        return $this->addChipAlias($cha);
    }
    /**
     * @return Collection|ChipImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }
    public function addImage(ChipImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setChip($this);
        }

        return $this;
    }
    public function removeImage(ChipImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getChip() === $this) {
                $image->setChip(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExpansionCard[]
     */
    public function getExpansionCards(): Collection
    {
        return $this->images;
    }
    public function addExpansionCard(ExpansionCard $expansionCard): self
    {
        if (!$this->expansionCards->contains($expansionCard)) {
            $this->expansionCards[] = $expansionCard;
            $expansionCard->addChip($this);
        }

        return $this;
    }
    public function removeExpansionCard(ExpansionCard $expansionCard): self
    {
        if ($this->expansionCards->contains($expansionCard)) {
            $this->expansionCards->removeElement($expansionCard);
            if ($expansionCard->getChips()->contains($this)) {
                $expansionCard->removeChip($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChipDocumentation[]
     */
    public function getDocumentations(): Collection
    {
        return $this->documentations;
    }
    public function addDocumentation(ChipDocumentation $documentation): self
    {
        if (!$this->documentations->contains($documentation)) {
            $this->documentations[] = $documentation;
            $documentation->setChip($this);
        }

        return $this;
    }
    public function removeDocumentation(ChipDocumentation $documentation): self
    {
        if ($this->documentations->contains($documentation)) {
            $this->documentations->removeElement($documentation);
            // set the owning side to null (unless already changed)
            if ($documentation->getChip() === $this) {
                $documentation->setChip(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PciDeviceId>
     */
    public function getPciDevs(): Collection
    {
        return $this->pciDevs;
    }

    public function getPciDevsLimited(): ?array
    {
        $result = array();
        $idx = 0;
        foreach($this->pciDevs as $dev){
            $idx++;
            array_push($result, $dev->getDev());
            if($idx > 2){
                if(count($this->pciDevs) > 3)
                    array_push($result, "...");
                break;
            }
        }
        return $result;
    }

    public function addPciDev(PciDeviceId $pciDev): self
    {
        if (!$this->pciDevs->contains($pciDev)) {
            $this->pciDevs->add($pciDev);
            $pciDev->setChip($this);
        }

        return $this;
    }

    public function removePciDev(PciDeviceId $pciDev): self
    {
        if ($this->pciDevs->removeElement($pciDev)) {
            // set the owning side to null (unless already changed)
            if ($pciDev->getChip() === $this) {
                $pciDev->setChip(null);
            }
        }

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

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): static
    {
        $this->sort = $sort;

        return $this;
    }
    public function getChipVendors(): Collection
    {
        $vendors = $this->getManufacturer()?->getPciVendorIds()->toArray() ?? [];
        return new ArrayCollection($vendors);
    }
    public function getAliasVendors(): Collection
    {
        $vendors = [];
        $mainVendor= $this->getManufacturer()?->getId() ?? null;
        foreach($this->getChipAliases() as $alias){
            $aliasVendors = $alias->getManufacturer()?->getPciVendorIds()->toArray() ?? [];
            $aliasId = $alias->getManufacturer()?->getId() ?? null;
            if(count($aliasVendors) > 0 && $aliasId != $mainVendor)
                $vendors = array_merge($vendors, $aliasVendors);
        }
        return new ArrayCollection(array_unique($vendors));
    }

    public function getType(): ?ExpansionChipType
    {
        return $this->type;
    }
    public function setType(?ExpansionChipType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMiscSpecs(): array
    {
        return $this->miscSpecs ?? [];
    }
    public function getMiscSpecsFormatted(): array
    {
        $output = [];
        foreach($this->getMiscSpecs() as $spec){
            $new = str_replace("\"","",json_encode($spec));
            $new = str_replace(":",": ",$new);
            array_push($output, substr($new, 1, -1));
        }
        return $output;
    }
    public function getSimpleMiscSpecs(): array
    {
        $output = [];
        foreach($this->getMiscSpecs() as $key => $value){
            if(!is_array($value))
                $output[$key] = $value;
        }
        return $output;
    }
    public function getTableMiscSpecs(): array
    {
        //Json inheritance from the family
        $miscSpecs = $this->getFamily()->getMiscSpecs();
        foreach($this->getMiscSpecs() as $key => $value){
            if(is_array($value)) {
                if (!array_key_exists($key, $miscSpecs)) {
                    $miscSpecs[$key] = [];
                }
                foreach($value as $key2 => $value2) {
                    $miscSpecs[$key][$key2] = $value2;
                }
            } else {
                $miscSpecs[$key] = $value;
            }
        }
        $output = [];
        foreach($miscSpecs as $key => $value){
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

    public function getAllDocs(): Collection
    {
        $docs = $this->getFamily()?->getEntityDocumentations()->toArray() ?? [];
        return new ArrayCollection($docs);
    }

    // dummy function used for the mini driver editor
    public function getChipsWithDrivers(): array
    {
        return [];
    }
}
