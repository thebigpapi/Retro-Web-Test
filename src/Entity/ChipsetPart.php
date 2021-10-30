<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChipsetPartRepository")
 */
class ChipsetPart extends Chip
{

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Chipset", mappedBy="chipsetParts")
     */
    private $chipsets;

    public function __construct()
    {
        parent::__construct();
        $this->chipsetParts = new ArrayCollection();
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
            $chipset->addChipsetPart($this);
        }

        return $this;
    }

    public function removeChipset(Chipset $chipset): self
    {
        if ($this->chipsets->contains($chipset)) {
            $this->chipsets->removeElement($chipset);
            // set the owning side to null (unless already changed)
            if ($chipset->getChipsetParts()->contains($this)) {
                $chipset->removeChipsetPart($this);
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
            return "$this->name ($this->partNumber)";
        } else {
            return "$this->partNumber";
        }
    }
}
