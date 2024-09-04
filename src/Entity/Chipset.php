<?php

namespace App\Entity;

use App\Entity\Traits\ImpreciseDateTrait;
use App\Repository\ChipsetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ChipsetRepository::class)]
class Chipset
{
    use ImpreciseDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'chipsets')]
    #[Assert\NotBlank(message: 'Manufacturer cannot be blank')]
    private $manufacturer;

    #[ORM\OneToMany(targetEntity: Motherboard::class, mappedBy: 'chipset')]
    private $motherboards;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    private $name;

    #[ORM\OneToMany(targetEntity: ChipsetAlias::class, mappedBy: 'chipset', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $chipsetAliases;

    /**
     * @var ArrayCollection<Chip>
     */
    #[ORM\ManyToMany(targetEntity: Chip::class, inversedBy: 'chipsets')]
    private $chips;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Encyclopedia link is longer than {{ limit }} characters.')]
    private $encyclopedia_link;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Part number is longer than {{ limit }} characters.')]
    private $part_no;

    #[ORM\OneToMany(targetEntity: ChipsetBiosCode::class, mappedBy: 'chipset', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $biosCodes;

    #[ORM\OneToMany(targetEntity: LargeFileChipset::class, mappedBy: 'chipset', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $drivers;

    #[ORM\Column(type: 'string', length: 8192, nullable: true)]
    #[Assert\Length(max: 8192, maxMessage: 'Description is longer than {{ limit }} characters.')]
    private $description;

    #[ORM\OneToMany(targetEntity: ChipsetDocumentation::class, mappedBy: 'chipset', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $documentations;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lastEdited = null;

    #[ORM\Column(length: 255)]
    private ?string $cachedName = null;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->chipsetAliases = new ArrayCollection();
        $this->chips = new ArrayCollection();
        $this->biosCodes = new ArrayCollection();
        $this->drivers = new ArrayCollection();
        $this->documentations = new ArrayCollection();
        $this->lastEdited = new \DateTime('now');
    }
    public function __toString(): string
    {
        return $this->getNameCached();
    }
    public function getId(): ?int
    {
        return $this->id;
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
    public function getNameCached(): string
    {
        return $this->getFullName() . " " . $this->getPartsCached();
    }
    public function getNameCachedSearch(): string
    {
        $fullName = $this->getManufacturer()?->getName();
        if($this->getId() == null){
            if($fullName == "")
                return "Not identified";
            return "any " . $fullName . " chipset";
        }
        if ($this->part_no) {
            $fullName .= " $this->part_no";
            if ($this->name) {
                $fullName .= " ($this->name)";
            }
            $fullName .= " " . $this->getPartsCached();
        } else {
            if ($this->name) {
                $fullName .= " $this->name";
                if(strtolower($this->name) != "unidentified")
                    $fullName .= " " . $this->getPartsCached();
            } else {
                $fullName .= " unidentified";
            }
        }
        $fullName = strlen($fullName) > 80 ? substr($fullName,0,80)."..." : $fullName;
        return $fullName;
    }
    public function getFullName(): string
    {
        $fullName = $this->getManufacturer()?->getName();
        if ($this->part_no) {
            $fullName .= " $this->part_no";
            if ($this->name) {
                $fullName .= " ($this->name)";
            }
        } else {
            if ($this->name) {
                $fullName .= " $this->name";
            } else {
                $fullName .= " Unidentified";
            }
        }
        return $fullName;
    }
    public function getParts(): string
    {
        $parts = "";
        if($this->chips->isEmpty()){
            return "[no parts]";
        }
        foreach ($this->chips as $key => $part) {
            if ($key === array_key_last($this->chips->getValues())) {
                $parts .= $part->getManufacturerAndPN();
            } else {
                $parts .= $part->getManufacturerAndPN() . ", ";
            }
        }
        if ($parts) {
            $parts = "[$parts]";
        }


        return "$parts";
    }
    public function getPartsCached(): string
    {
        return ($this->getCachedName() != "") ? $this->getCachedName() : "[uncached parts]";
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
            $motherboard->setChipset($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            // set the owning side to null (unless already changed)
            if ($motherboard->getChipset() === $this) {
                $motherboard->setChipset(null);
            }
        }

        return $this;
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
    /**
     * @return Collection|Chip[]
     */
    public function getchips(): Collection
    {
        $sortedChips = $this->chips->toArray();

        $res = usort($sortedChips, function ($a, $b) {
            return ($a->getFullName() <=> $b->getFullName());
        });

        if ($res) {
            return new ArrayCollection($sortedChips);
        } else {
            return $this->chips;
        }
    }
    public function addChip(Chip $chip): self
    {
        if (!$this->chips->contains($chip)) {
            $this->chips[] = $chip;
            $chip->addChipset($this);
        }

        return $this;
    }
    public function removeChip(Chip $chip): self
    {
        if ($this->chips->contains($chip)) {
            $this->chips->removeElement($chip);
            // set the owning side to null (unless already changed)
            if ($chip->getChipsets()->contains($this)) {
                $chip->removeChipset($this);
            }
        }

        return $this;
    }
    public function getEncyclopediaLink(): ?string
    {
        return $this->encyclopedia_link;
    }
    public function setEncyclopediaLink(?string $encyclopedia_link): self
    {
        $this->encyclopedia_link = $encyclopedia_link;

        return $this;
    }
    public function getPartNumber(): ?string
    {
        return $this->getPartNo();
    }
    public function getNameWithoutManuf(): string
    {
        if ($this->name) {
            return $this->part_no . " (" . $this->name . ")";
        }
        return $this->part_no;
    }
    public function getPartNo(): ?string
    {
        return $this->part_no;
    }
    public function setPartNo(?string $part_no): self
    {
        $this->part_no = $part_no;

        return $this;
    }
    /**
     * @return Collection|ChipsetBiosCode[]
     */
    public function getBiosCodes(): Collection
    {
        return $this->biosCodes;
    }
    public function addBiosCode(ChipsetBiosCode $biosCode): self
    {
        if (!$this->biosCodes->contains($biosCode)) {
            $this->biosCodes[] = $biosCode;
            $biosCode->setChipset($this);
        }

        return $this;
    }
    public function removeBiosCode(ChipsetBiosCode $biosCode): self
    {
        if ($this->biosCodes->contains($biosCode)) {
            $this->biosCodes->removeElement($biosCode);
            // set the owning side to null (unless already changed)
            if ($biosCode->getChipset() === $this) {
                $biosCode->setChipset(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|LargeFileChipset[]
     */
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }
    public function getAllDrivers(): Collection
    {
        $drivers = $this->drivers->toArray();
        foreach ($this->getchips() as $chip) {
            $drivers = array_merge($drivers, $chip->getDrivers()->toArray());
        }
        return new ArrayCollection($drivers);
    }
    public function addDriver(LargeFileChipset $driver): self
    {
        if (!$this->drivers->contains($driver)) {
            $this->drivers[] = $driver;
            $driver->setChipset($this);
        }

        return $this;
    }
    public function removeDriver(LargeFileChipset $driver): self
    {
        if ($this->drivers->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getChipset() === $this) {
                $driver->setChipset(null);
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
     * @return Collection|ChipsetDocumentation[]
     */
    public function getDocumentations(): Collection
    {
        return $this->documentations;
    }
    public function addDocumentation(ChipsetDocumentation $documentation): self
    {
        if (!$this->documentations->contains($documentation)) {
            $this->documentations[] = $documentation;
            $documentation->setChipset($this);
        }

        return $this;
    }
    public function removeDocumentation(ChipsetDocumentation $documentation): self
    {
        if ($this->documentations->contains($documentation)) {
            $this->documentations->removeElement($documentation);
            // set the owning side to null (unless already changed)
            if ($documentation->getChipset() === $this) {
                $documentation->setChipset(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|ChipsetAlias[]
     */
    public function getChipsetAliases(): Collection
    {
        return $this->chipsetAliases;
    }
    public function addChipsetAlias(ChipsetAlias $chipsetAlias): self
    {
        if (!$this->chipsetAliases->contains($chipsetAlias)) {
            $this->chipsetAliases[] = $chipsetAlias;
            $chipsetAlias->setChipset($this);
        }

        return $this;
    }
    public function removeChipsetAlias(ChipsetAlias $chipsetAlias): self
    {
        if ($this->chipsetAliases->contains($chipsetAlias)) {
            $this->chipsetAliases->removeElement($chipsetAlias);
            // set the owning side to null (unless already changed)
            if ($chipsetAlias->getChipset() === $this) {
                $chipsetAlias->setChipset(null);
            }
        }

        return $this;
    }
    public function addAlias(Manufacturer $manuf, ?string $name, string $partNumber): self
    {
        $ca = new ChipsetAlias();
        $ca->setManufacturer($manuf);
        $ca->setChipset($this);
        $ca->setName($name);
        $ca->setPartNumber($partNumber);

        return $this->addChipsetAlias($ca);
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

    public function getMetaDescription(): string
    {
        return "Get info, documentation and more about the " . $this->getFullName() . " chipset.";
    }

    public function getCachedName(): ?string
    {
        return $this->cachedName;
    }

    public function updateCachedName(): self
    {
        $this->cachedName = $this->getParts();

        return $this;
    }
    public function getChipDocs(): Collection
    {
        $docs = [];
        foreach ($this->getchips() as $chip) {
            $docs = array_merge($docs, $chip->getDocumentations()->toArray());
        }
        return new ArrayCollection($docs);
    }

    public function getChipsWithDrivers(): array
    {
        $driverChips = [];
        foreach($this->chips as $chip){
            if(!$chip->getDrivers()->isEmpty())
                array_push($driverChips, $chip->getFullName());
        }
        return $driverChips;
    }

    public function getChipKnownIssues(): array
    {
        $chipIssues = array();
        if($this->chips->isEmpty())
            return $chipIssues;
        foreach($this->chips as $chip){
            if(!$chip->getKnownIssues()->isEmpty())
                $chipIssues[$chip->getFullName()] = $chip->getKnownIssues();
        }
        return $chipIssues;
    }
}
