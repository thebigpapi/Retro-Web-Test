<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChipsetPartRepository")
 */
class ChipsetPart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manufacturer", inversedBy="chipsetParts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $manufacturer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chip_no;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ChipsetPart", mappedBy="chipsetParts")
     */
    private $chipsets;

    public function __construct()
    {
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getChipNo(): ?string
    {
        return $this->chip_no;
    }

    public function setChipNo(string $chip_no): self
    {
        $this->chip_no = $chip_no;

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
            $chipsetPart->setChipsetPart($this);
        }

        return $this;
    }

    public function removeChipsetPart(ChipsetPart $chipsetPart): self
    {
        if ($this->chipsetParts->contains($chipsetPart)) {
            $this->chipsetParts->removeElement($chipsetPart);
            // set the owning side to null (unless already changed)
            if ($chipsetPart->getChipsetPart() === $this) {
                $chipsetPart->setChipsetPart(null);
            }
        }

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->manufacturer->getShortNameIfExist() . " " . $this->getShortName();
    }

    public function getShortName(): ?string
    {
        if ($this->name) {
            return "$this->name ($this->chip_no)"; 
        }
        else {
            return "$this->chip_no"; 
        }
    }
}
