<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: 'App\Repository\ManufacturerRepository')]
#[UniqueEntity(fields: ['name', 'fullName'])]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
class Manufacturer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true, unique: true)]
    #[Assert\Length(max: 255, maxMessage: 'Full name is longer than {{ limit }} characters.')]
    private $fullName;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    private $name;

    #[ORM\OneToMany(targetEntity: Motherboard::class, mappedBy: 'manufacturer')]
    private $motherboards;

    #[ORM\OneToMany(targetEntity: Chipset::class, mappedBy: 'manufacturer')]
    private $chipsets;

    #[ORM\OneToMany(targetEntity: ChipsetAlias::class, mappedBy: 'manufacturer')]
    private $chipsetAliases;

    #[ORM\OneToMany(targetEntity: MotherboardAlias::class, mappedBy: 'manufacturer')]
    private $motherboardAliases;

    #[ORM\OneToMany(targetEntity: Chip::class, mappedBy: 'manufacturer')]
    private $chips;

    #[ORM\OneToMany(targetEntity: ChipAlias::class, mappedBy: 'manufacturer')]
    private $chipAliases;

    #[ORM\OneToMany(targetEntity: ManufacturerBiosManufacturerCode::class, mappedBy: 'manufacturer', orphanRemoval: true, cascade: ['persist'])]
    private $biosCodes;

    #[ORM\OneToMany(targetEntity: ChipsetBiosCode::class, mappedBy: 'biosManufacturer')]
    private $chipsetBiosCodes;

    #[ORM\OneToMany(targetEntity: OsFlag::class, mappedBy: 'manufacturer')]
    private $osFlags;

    #[ORM\OneToMany(mappedBy: 'manufacturer', targetEntity: PciVendorId::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $pciVendorIds;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $fccid = null;

    #[ORM\OneToMany(mappedBy: 'manufacturer', targetEntity: StorageDevice::class)]
    private Collection $storageDevices;

    #[ORM\OneToMany(mappedBy: 'manufacturer', targetEntity: ManufacturerCode::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $manufacturerCodes;

    #[ORM\Column(length: 8192, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'manufacturer', targetEntity: EntityImage::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $entityImages;

    #[ORM\OneToMany(mappedBy: 'manufacturer', targetEntity: ExpansionCardAlias::class)]
    private Collection $expansionCardAliases;

    #[ORM\OneToMany(mappedBy: 'manufacturer', targetEntity: ExpansionCard::class)]
    private Collection $expansionCards;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->chipsets = new ArrayCollection();
        $this->chipsetAliases = new ArrayCollection();
        $this->motherboardAliases = new ArrayCollection();
        $this->chips = new ArrayCollection();
        $this->chipAliases = new ArrayCollection();
        $this->biosCodes = new ArrayCollection();
        $this->chipsetBiosCodes = new ArrayCollection();
        $this->osFlags = new ArrayCollection();
        $this->pciVendorIds = new ArrayCollection();
        $this->storageDevices = new ArrayCollection();
        $this->manufacturerCodes = new ArrayCollection();
        $this->entityImages = new ArrayCollection();
        $this->expansionCardAliases = new ArrayCollection();
        $this->expansionCards = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->name;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getFullName(): ?string
    {
        return $this->fullName;
    }
    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

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
            $motherboard->setManufacturer($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            // set the owning side to null (unless already changed)
            if ($motherboard->getManufacturer() === $this) {
                $motherboard->setManufacturer(null);
            }
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
            $chipset->setManufacturer($this);
        }

        return $this;
    }
    public function removeChipset(Chipset $chipset): self
    {
        if ($this->chipsets->contains($chipset)) {
            $this->chipsets->removeElement($chipset);
            // set the owning side to null (unless already changed)
            if ($chipset->getManufacturer() === $this) {
                $chipset->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChipsetAlias[]
     */
    public function getChipsetAlias(): Collection
    {
        return $this->motherboardAliases;
    }
    public function addChipsetAlias(ChipsetAlias $chipsetAlias): self
    {
        if (!$this->chipsetAliases->contains($chipsetAlias)) {
            $this->chipsetAliases[] = $chipsetAlias;
            $chipsetAlias->setManufacturer($this);
        }

        return $this;
    }
    public function removeChipsetAlias(ChipsetAlias $chipsetAlias): self
    {
        if ($this->chipsetAliases->contains($chipsetAlias)) {
            $this->chipsetAliases->removeElement($chipsetAlias);
            // set the owning side to null (unless already changed)
            if ($chipsetAlias->getManufacturer() === $this) {
                $chipsetAlias->setManufacturer(null);
            }
        }

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
            $motherboardAlias->setManufacturer($this);
        }

        return $this;
    }
    public function removeMotherboardAlias(MotherboardAlias $motherboardAlias): self
    {
        if ($this->motherboardAliases->contains($motherboardAlias)) {
            $this->motherboardAliases->removeElement($motherboardAlias);
            // set the owning side to null (unless already changed)
            if ($motherboardAlias->getManufacturer() === $this) {
                $motherboardAlias->setManufacturer(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Chip[]
     */
    public function getChips(): Collection
    {
        return $this->chips;
    }
    public function addChip(Chip $chip): self
    {
        if (!$this->chips->contains($chip)) {
            $this->chips[] = $chip;
            $chip->setManufacturer($this);
        }

        return $this;
    }
    public function removeChip(Chip $chip): self
    {
        if ($this->chips->contains($chip)) {
            $this->chips->removeElement($chip);
            // set the owning side to null (unless already changed)
            if ($chip->getManufacturer() === $this) {
                $chip->setManufacturer(null);
            }
        }

        return $this;
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
            $chipAlias->setManufacturer($this);
        }

        return $this;
    }
    public function removeChipAlias(ChipAlias $chipAlias): self
    {
        if ($this->chipAliases->contains($chipAlias)) {
            $this->chipAliases->removeElement($chipAlias);
            // set the owning side to null (unless already changed)
            if ($chipAlias->getManufacturer() === $this) {
                $chipAlias->setManufacturer(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|ManufacturerBiosManufacturerCode[]
     */
    public function getBiosCodes(): Collection
    {
        return $this->biosCodes;
    }
    public function addBiosCode(ManufacturerBiosManufacturerCode $biosCode): self
    {
        if (!$this->biosCodes->contains($biosCode)) {
            $this->biosCodes[] = $biosCode;
            $biosCode->setManufacturer($this);
        }

        return $this;
    }
    public function removeBiosCode(ManufacturerBiosManufacturerCode $biosCode): self
    {
        if ($this->biosCodes->contains($biosCode)) {
            $this->biosCodes->removeElement($biosCode);
            // set the owning side to null (unless already changed)
            if ($biosCode->getManufacturer() === $this) {
                $biosCode->setManufacturer(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|ChipsetBiosCode[]
     */
    public function getChipsetBiosCodes(): Collection
    {
        return $this->chipsetBiosCodes;
    }
    public function addChipsetBiosCode(ChipsetBiosCode $chipsetBiosCode): self
    {
        if (!$this->chipsetBiosCodes->contains($chipsetBiosCode)) {
            $this->chipsetBiosCodes[] = $chipsetBiosCode;
            $chipsetBiosCode->setBiosManufacturer($this);
        }

        return $this;
    }
    public function removeChipsetBiosCode(ChipsetBiosCode $chipsetBiosCode): self
    {
        if ($this->chipsetBiosCodes->contains($chipsetBiosCode)) {
            $this->chipsetBiosCodes->removeElement($chipsetBiosCode);
            // set the owning side to null (unless already changed)
            if ($chipsetBiosCode->getBiosManufacturer() === $this) {
                $chipsetBiosCode->setBiosManufacturer(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|OsFlag[]
     */
    public function getOsFlags(): Collection
    {
        return $this->osFlags;
    }
    public function addOsFlag(OsFlag $osFlag): self
    {
        if (!$this->osFlags->contains($osFlag)) {
            $this->osFlags[] = $osFlag;
            $osFlag->setManufacturer($this);
        }

        return $this;
    }
    public function removeOsFlag(OsFlag $osFlag): self
    {
        if ($this->osFlags->removeElement($osFlag)) {
            // set the owning side to null (unless already changed)
            if ($osFlag->getManufacturer() === $this) {
                $osFlag->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PciVendorId>
     */
    public function getPciVendorIds(): Collection
    {
        return $this->pciVendorIds;
    }

    public function addPciVendorId(PciVendorId $pciVendorId): self
    {
        if (!$this->pciVendorIds->contains($pciVendorId)) {
            $this->pciVendorIds->add($pciVendorId);
            $pciVendorId->setManufacturer($this);
        }

        return $this;
    }

    public function removePciVendorId(PciVendorId $pciVendorId): self
    {
        if ($this->pciVendorIds->removeElement($pciVendorId)) {
            // set the owning side to null (unless already changed)
            if ($pciVendorId->getManufacturer() === $this) {
                $pciVendorId->setManufacturer(null);
            }
        }

        return $this;
    }

    public function getFccid(): ?string
    {
        return $this->fccid;
    }

    public function setFccid(?string $fccid): self
    {
        $this->fccid = $fccid;

        return $this;
    }

    /**
     * @return Collection<int, StorageDevice>
     */
    public function getStorageDevices(): Collection
    {
        return $this->storageDevices;
    }

    public function addStorageDevice(StorageDevice $storageDevice): self
    {
        if (!$this->storageDevices->contains($storageDevice)) {
            $this->storageDevices->add($storageDevice);
            $storageDevice->setManufacturer($this);
        }

        return $this;
    }

    public function removeStorageDevice(StorageDevice $storageDevice): self
    {
        if ($this->storageDevices->removeElement($storageDevice)) {
            // set the owning side to null (unless already changed)
            if ($storageDevice->getManufacturer() === $this) {
                $storageDevice->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ManufacturerCode>
     */
    public function getManufacturerCodes(): Collection
    {
        return $this->manufacturerCodes;
    }

    public function addManufacturerCode(ManufacturerCode $manufacturerCode): self
    {
        if (!$this->manufacturerCodes->contains($manufacturerCode)) {
            $this->manufacturerCodes->add($manufacturerCode);
            $manufacturerCode->setManufacturer($this);
        }

        return $this;
    }

    public function removeManufacturerCode(ManufacturerCode $manufacturerCode): self
    {
        if ($this->manufacturerCodes->removeElement($manufacturerCode)) {
            // set the owning side to null (unless already changed)
            if ($manufacturerCode->getManufacturer() === $this) {
                $manufacturerCode->setManufacturer(null);
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
     * @return Collection<int, EntityImage>
     */
    public function getEntityImages(): Collection
    {
        return $this->entityImages;
    }

    public function addEntityImage(EntityImage $entityImage): self
    {
        if (!$this->entityImages->contains($entityImage)) {
            $this->entityImages->add($entityImage);
            $entityImage->setManufacturer($this);
        }

        return $this;
    }

    public function removeEntityImage(EntityImage $entityImage): self
    {
        if ($this->entityImages->removeElement($entityImage)) {
            // set the owning side to null (unless already changed)
            if ($entityImage->getManufacturer() === $this) {
                $entityImage->setManufacturer(null);
            }
        }

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
            $expansionCardAlias->setManufacturer($this);
        }

        return $this;
    }

    public function removeExpansionCardAlias(ExpansionCardAlias $expansionCardAlias): static
    {
        if ($this->expansionCardAliases->removeElement($expansionCardAlias)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardAlias->getManufacturer() === $this) {
                $expansionCardAlias->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCard>
     */
    public function getExpansionCards(): Collection
    {
        return $this->expansionCards;
    }

    public function addExpansionCard(ExpansionCard $expansionCard): static
    {
        if (!$this->expansionCards->contains($expansionCard)) {
            $this->expansionCards->add($expansionCard);
            $expansionCard->setManufacturer($this);
        }

        return $this;
    }

    public function removeExpansionCard(ExpansionCard $expansionCard): static
    {
        if ($this->expansionCards->removeElement($expansionCard)) {
            // set the owning side to null (unless already changed)
            if ($expansionCard->getManufacturer() === $this) {
                $expansionCard->setManufacturer(null);
            }
        }

        return $this;
    }
}
