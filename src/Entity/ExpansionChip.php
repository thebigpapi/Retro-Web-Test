<?php

namespace App\Entity;

use App\Entity\Chipset;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ExpansionChipRepository')]
class ExpansionChip extends Chip
{
    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'expansionChips')]
    private $motherboards;

    #[ORM\ManyToMany(targetEntity: Chipset::class, mappedBy: 'expansionChips')]
    private $chipsets;

    #[ORM\OneToMany(targetEntity: LargeFileExpansionChip::class, mappedBy: 'expansionChip', orphanRemoval: true, cascade: ['persist'])]
    private $drivers;

    #[ORM\ManyToOne(targetEntity: ExpansionChipType::class, inversedBy: 'expansionChips')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\Column(length: 8192, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime', mapped: false)]
    private $lastEdited;

    public function __construct()
    {
        parent::__construct();
        $this->motherboards = new ArrayCollection();
        $this->chipsets = new ArrayCollection();
        $this->drivers = new ArrayCollection();
        $this->documentations = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getNameWithManufacturer();
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
    public function getType(): ?ExpansionChipType
    {
        return $this->type;
    }
    public function setType(?ExpansionChipType $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getNameWithManufacturer()
    {
        if ($this->name) {
            return $this->getManufacturer()->getName() . " " . $this->partNumber . " (" . $this->name . ")";
        }
        return $this->getManufacturer()->getName() . " " . $this->partNumber;
    }
    public function getManufacturerAndPN()
    {
        return $this->getManufacturer()->getName() . " " . $this->partNumber;
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
            $motherboard->addExpansionChip($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            $motherboard->removeExpansionChip($this);
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
            $chipset->addExpansionChip($this);
        }

        return $this;
    }
    public function removeChipset(Chipset $chipset): self
    {
        if ($this->chipsets->contains($chipset)) {
            $this->chipsets->removeElement($chipset);
            // set the owning side to null (unless already changed)
            if ($chipset->getExpansionChips()->contains($this)) {
                $chipset->removeExpansionChip($this);
            }
        }

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
            $driver->setExpansionChip($this);
        }

        return $this;
    }
    public function removeDriver(LargeFileExpansionChip $driver): self
    {
        if ($this->drivers->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getExpansionChip() === $this) {
                $driver->setExpansionChip(null);
            }
        }

        return $this;
    }

    public function setExpansionChipType(?ExpansionChipType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getExpansionChipType(): ?ExpansionChipType
    {
        return $this->type;
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
}
