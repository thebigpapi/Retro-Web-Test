<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ChipsetRepository')]
class Chipset
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'chipsets')]
    private $manufacturer;

    #[ORM\OneToMany(targetEntity: Motherboard::class, mappedBy: 'chipset')]
    private $motherboards;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\OneToMany(targetEntity: ChipsetAlias::class, mappedBy: 'chipset', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $chipsetAliases;

    /**
     * @var ArrayCollection<ChipsetPart>
     */
    #[ORM\ManyToMany(targetEntity: ChipsetPart::class, inversedBy: 'chipsets')]
    private $chipsetParts;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Encyclopedia link is longer than {{ limit }} characters, try to make it shorter.')]
    private $encyclopedia_link;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 16, maxMessage: 'Release date is longer than {{ limit }} characters, try to make it shorter.')]
    private $release_date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Part number is longer than {{ limit }} characters, try to make it shorter.')]
    private $part_no;

    #[ORM\OneToMany(targetEntity: ChipsetBiosCode::class, mappedBy: 'chipset', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $biosCodes;

    #[ORM\OneToMany(targetEntity: LargeFileChipset::class, mappedBy: 'chipset', orphanRemoval: true, cascade: ['persist'])]
    private $drivers;

    #[ORM\Column(type: 'string', length: 8192, nullable: true)]
    #[Assert\Length(max: 8192, maxMessage: 'Description is longer than {{ limit }} characters, try to make it shorter.')]
    private $description;

    #[ORM\OneToMany(targetEntity: ChipsetDocumentation::class, mappedBy: 'chipset', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $documentations;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lastEdited = null;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->chipsetAliases = new ArrayCollection();
        $this->chipsetParts = new ArrayCollection();
        $this->biosCodes = new ArrayCollection();
        $this->drivers = new ArrayCollection();
        $this->documentations = new ArrayCollection();
        $this->lastEdited = new \DateTime('now');
    }
    public function __toString(): string
    {
        return $this->getFullNameParts();
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
    public function getFullReference(): string
    {
        $fullName = "";
        if ($this->part_no) {
            $fullName = $fullName . " $this->part_no";
            if ($this->name) {
                $fullName = $fullName . " ($this->name)";
            }
        } else {
            if ($this->name) {
                $fullName = $fullName . " $this->name";
            } else {
                $fullName = $fullName . " Unidentified";
            }
        }
        return "$fullName";
    }
    public function getFullNameParts(): string
    {
        if ($this->getManufacturer()) {
            $manufacturer = $this->getManufacturer()->getShortNameIfExist();
        } else {
            $manufacturer = "";
        }

        $fullName = $manufacturer . $this->getFullReference() . ' ' . $this->getParts();
        return "$fullName";
    }
    public function getFullName(): string
    {
        if ($this->getManufacturer()) {
            $manufacturer = $this->getManufacturer()->getShortNameIfExist();
        } else {
            $manufacturer = "";
        }

        $fullName = $manufacturer . $this->getFullReference();
        return "$fullName";
    }
    public function getParts(): string
    {
        $chipset = "";
        foreach ($this->chipsetParts as $key => $part) {
            if ($key === array_key_last($this->chipsetParts->getValues())) {
                $chipset = $chipset . $part->getShortNamePN();
            } else {
                $chipset = $chipset . $part->getShortNamePN() . ", ";
            }
        }
        if ($chipset) {
            $chipset = "[$chipset]";
        }


        return "$chipset";
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
     * @return Collection|ChipsetPart[]
     */
    public function getChipsetParts(): Collection
    {
        $sortedChips = $this->chipsetParts->toArray();

        $res = usort($sortedChips, function ($a, $b) {
            return ($a->getRank() <=> $b->getRank());
        });

        if ($res) {
            return new ArrayCollection($sortedChips);
        } else {
            return $this->chipsetParts;
        }
    }
    public function addChipsetPart(ChipsetPart $chipsetPart): self
    {
        if (!$this->chipsetParts->contains($chipsetPart)) {
            $this->chipsetParts[] = $chipsetPart;
            $chipsetPart->addChipset($this);
        }

        return $this;
    }
    public function removeChipsetPart(ChipsetPart $chipsetPart): self
    {
        if ($this->chipsetParts->contains($chipsetPart)) {
            $this->chipsetParts->removeElement($chipsetPart);
            // set the owning side to null (unless already changed)
            if ($chipsetPart->getChipsets()->contains($this)) {
                $chipsetPart->removeChipset($this);
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
    public function getReleaseDate(): ?string
    {
        return $this->release_date;
    }
    public function setReleaseDate(?string $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
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
    public function addManual(ChipsetDocumentation $documentation): self
    {
        if (!$this->documentations->contains($documentation)) {
            $this->documentations[] = $documentation;
            $documentation->setChipset($this);
        }

        return $this;
    }
    public function removeManual(ChipsetDocumentation $documentation): self
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

    public function getPrettyTitle(): string
    {
        $strBuilder = "";
        $mfgData = $this->getManufacturer();
        if ($mfgData != null) {
            $strBuilder .= $mfgData->getShortNameIfExist();
        } else {
            $strBuilder .= "[Unknown]";
        }
        $strBuilder .= $this->getFullReference();
        return $strBuilder;
    }

    public function getMetaDescription(): string
    {
        $strBuilder = "Get info, documentation and more about the ";
        $strBuilder .= $this->getPrettyTitle();
        $strBuilder .= " chipset";
        $relDate = $this->getReleaseDate();
        if (strlen($relDate) > 0) {
            $strBuilder .= ", released " . $relDate;
        }
        $strBuilder .= ".";

        return $strBuilder;
    }
}
