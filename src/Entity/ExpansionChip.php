<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ExpansionChipRepository')]
class ExpansionChip extends Chip
{

    #[ORM\OneToMany(targetEntity: Motherboard::class, mappedBy: 'expansionChip')]
    private $motherboards;

    #[ORM\OneToMany(targetEntity: LargeFileExpansionChip::class, mappedBy: 'expansionChip', orphanRemoval: true, cascade: ['persist'])]
    private $drivers;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\ExpansionChipType', inversedBy: 'expansionChips')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    public function __construct()
    {
        parent::__construct();
        $this->motherboards = new ArrayCollection();
        $this->drivers = new ArrayCollection();
        $this->documentations = new ArrayCollection();
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
            if($this->partNumber) {
                return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name . " (" . $this->partNumber . ")";
            }
            return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name;
        }
        if($this->partNumber) {
            return $this->getManufacturer()->getShortNameIfExist() . " " . $this->partNumber;
        }
        return $this->getManufacturer()->getShortNameIfExist() . " Unidentified";
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
            $motherboard->setExpansionChip($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            // set the owning side to null (unless already changed)
            if ($motherboard->getExpansionChip() === $this) {
                $motherboard->setExpansionChip(null);
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
            $driver->setExpansionchipsets($this);
        }

        return $this;
    }
    public function removeDriver(LargeFileExpansionChip $driver): self
    {
        if ($this->drivers->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getExpansionchipsets() === $this) {
                $driver->setExpansionchipsets(null);
            }
        }

        return $this;
    }
}
