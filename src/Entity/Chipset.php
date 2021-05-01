<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChipsetRepository")
 */
class Chipset
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manufacturer", inversedBy="chipsets")
     */
    private $manufacturer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Motherboard", mappedBy="chipset")
     */
    private $motherboards;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ChipsetPart", inversedBy="chipsets")
     */
    private $chipsetParts;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $encyclopedia_link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $release_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $part_no;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->chipsetParts = new ArrayCollection();
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


    public function getMainChipWithManufacturer(): ?string
    {
        if($this->getManufacturer()){
            $manufacturer = $this->getManufacturer()->getShortNameIfExist();
        }
        else {
            $manufacturer = "";
        }
        
        $fullName = $manufacturer;
        if ($this->part_no) {
            $fullName = $fullName . " $this->part_no";
            if ($this->name) {
                $fullName = $fullName . " ($this->name)";
            }
        }
        else {
            if ($this->name) {
                $fullName = $fullName . " $this->name";
            }
            else {
                $fullName = $fullName . " Unidentified";
            }
        }
        $chipset = "";
        foreach($this->chipsetParts as $key => $part) {
            if ($key === array_key_last($this->chipsetParts->getValues())) {
                $chipset = $chipset . $part->getShortName();
            }
            else {
                $chipset = $chipset . $part->getShortName() . ", ";
            }
            
        }
        if ($chipset) {
            $chipset = "[$chipset]";
        }


        return "$fullName $chipset";
    }

    public function getFullReference(): ?string
    {
        $fullName = "";
        if ($this->part_no) {
            $fullName = $fullName . " $this->part_no";
            if ($this->name) {
                $fullName = $fullName . " ($this->name)";
            }
        }
        else {
            if ($this->name) {
                $fullName = $fullName . " $this->name";
            }
            else {
                $fullName = $fullName . " Unidentified";
            }
        }
        $chipset = "";
        foreach($this->chipsetParts as $key => $part) {
            if ($key === array_key_last($this->chipsetParts->getValues())) {
                $chipset = $chipset . $part->getShortName();
            }
            else {
                $chipset = $chipset . $part->getShortName() . ", ";
            }

        }
        if ($chipset) {
            $chipset = "[$chipset]";
        }


        return "$fullName $chipset";
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
        return $this->chipsetParts;
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
}
