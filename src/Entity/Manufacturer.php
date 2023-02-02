<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: 'App\Repository\ManufacturerRepository')]
#[UniqueEntity(fields: ['name', 'shortName'])]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
class Manufacturer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\Length(max:255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true, unique: true)]
    #[Assert\Length(max:255, maxMessage: 'Short name is longer than {{ limit }} characters, try to make it shorter.')]
    private $shortName;

    #[ORM\OneToMany(targetEntity: 'App\Entity\Motherboard', mappedBy: 'manufacturer')]
    private $motherboards;

    #[ORM\OneToMany(targetEntity: 'App\Entity\Chipset', mappedBy: 'manufacturer')]
    private $chipsets;

    #[ORM\OneToMany(targetEntity: ChipsetAlias::class, mappedBy: 'manufacturer')]
    private $chipsetAliases;

    #[ORM\OneToMany(targetEntity: 'App\Entity\MotherboardAlias', mappedBy: 'manufacturer')]
    private $motherboardAliases;

    #[ORM\OneToMany(targetEntity: 'App\Entity\Chip', mappedBy: 'manufacturer')]
    private $chips;

    #[ORM\OneToMany(targetEntity: 'App\Entity\ChipAlias', mappedBy: 'manufacturer')]
    private $chipAliases;

    #[ORM\OneToMany(targetEntity: 'App\Entity\ManufacturerBiosManufacturerCode', mappedBy: 'manufacturer', orphanRemoval: true, cascade: ['persist'])]
    private $biosCodes;

    #[ORM\OneToMany(targetEntity: 'App\Entity\ChipsetBiosCode', mappedBy: 'biosManufacturer')]
    private $chipsetBiosCodes;

    #[ORM\OneToMany(targetEntity: OsFlag::class, mappedBy: 'manufacturer')]
    private $osFlags;

    #[ORM\OneToMany(mappedBy: 'manufacturer', targetEntity: PciVendorId::class,  orphanRemoval: true, cascade: ['persist'])]
    private Collection $pciVendorIds;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $fccid = null;

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
    public function getShortName(): ?string
    {
        return $this->shortName;
    }
    public function setShortName(?string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }
    public function getShortNameIfExist(): ?string
    {
        if ($this->shortName) {
            return $this->shortName;
        }
        return $this->name;
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
}
