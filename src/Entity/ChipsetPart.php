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
     * @ORM\ManyToMany(targetEntity="App\Entity\ChipsetPart", mappedBy="chipsetParts")
     */
    private $chipsets;

    public function __construct()
    {
        $this->chipsetParts = new ArrayCollection();
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
