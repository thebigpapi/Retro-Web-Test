<?php

namespace App\Entity;

use App\Entity\Chipset;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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
    #[Assert\Valid()]
    private $drivers;

    #[ORM\Column(length: 8192, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: ExpansionCard::class, mappedBy: 'expansionChips')]
    private Collection $expansionCards;

    #[ORM\OneToMany(mappedBy: 'expansionChip', targetEntity: ExpansionChipBios::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $expansionChipBios;

    #[ORM\Column(type: 'datetime', mapped: false)]
    private $lastEdited;


    public function __construct()
    {
        parent::__construct();
        $this->motherboards = new ArrayCollection();
        $this->chipsets = new ArrayCollection();
        $this->drivers = new ArrayCollection();
        $this->documentations = new ArrayCollection();
        $this->expansionCards = new ArrayCollection();
        $this->expansionChipBios = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getFullName() . $this->getAllAliases();
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
    
    public function getFullName(): string
    {
        $name = $this->getManufacturer()?->getName() ?? "[unknown]";
        if ($this->name) {
            return $name . " " . $this->partNumber . " (" . $this->name . ")";
        }
        return $name . " " . $this->partNumber;
    }
    public function getAllAliases(): string
    {
        if($this->getChipAliases()->isEmpty())
            return "";
        $aliases = " [";
        foreach($this->getChipAliases() as $alias){
            $aliases .= $alias->getPartNumber() ? $alias->getPartNumber() . ", ": "";
        }
        return substr($aliases, 0, -2) . "]";
    }
    public function getManufacturerAndPN()
    {
        return ($this->getManufacturer()?->getName() ?? '[unknown]') . " " . $this->partNumber;
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
     * @return Collection|ExpansionCard[]
     */
    public function getExpansionCards(): Collection
    {
        return $this->expansionCards;
    }
    public function addExpansionCard(ExpansionCard $expansionCard): self
    {
        if (!$this->expansionCards->contains($expansionCard)) {
            $this->expansionCards[] = $expansionCard;
            $expansionCard->addExpansionChip($this);
        }

        return $this;
    }
    public function removeExpansionCard(ExpansionCard $expansionCard): self
    {
        if ($this->expansionCards->contains($expansionCard)) {
            $this->expansionCards->removeElement($expansionCard);
            // set the owning side to null (unless already changed)
            if ($expansionCard->getExpansionChips()->contains($this)) {
                $expansionCard->removeExpansionChip($this);
            }
        }

        return $this;
    }
    /**
     * @return Collection<int, ExpansionChipBios>
     */
    public function getExpansionChipBios(): Collection
    {
        return $this->expansionChipBios;
    }

    public function addExpansionChipBio(ExpansionChipBios $expansionChipBio): static
    {
        if (!$this->expansionChipBios->contains($expansionChipBio)) {
            $this->expansionChipBios->add($expansionChipBio);
            $expansionChipBio->setExpansionChip($this);
        }

        return $this;
    }

    public function removeExpansionChipBio(ExpansionChipBios $expansionChipBio): static
    {
        if ($this->expansionChipBios->removeElement($expansionChipBio)) {
            // set the owning side to null (unless already changed)
            if ($expansionChipBio->getExpansionChip() === $this) {
                $expansionChipBio->setExpansionChip(null);
            }
        }

        return $this;
    }
    public function isExpansionChipBios(): bool
    {
        if(isset($this->expansionChipBios))
            if(count($this->expansionChipBios) > 0)
                return true;
        return false;
    }

    public function getChipsWithDrivers(): array
    {
        return [];
    }
}
