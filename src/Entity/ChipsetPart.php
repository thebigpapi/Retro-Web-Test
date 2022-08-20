<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\ChipsetPartRepository')]
class ChipsetPart extends Chip
{
    #[ORM\ManyToMany(targetEntity: 'App\Entity\Chipset', mappedBy: 'chipsetParts')]
    private $chipsets;
    
    #[ORM\OneToMany(targetEntity: 'App\Entity\ChipDocumentation', mappedBy: 'chip', orphanRemoval: true, cascade: ['persist'])]
    private $documentations;

    #[ORM\Column(type: 'string', length: 8192, nullable: true)]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $rank;

    public function __construct()
    {
        parent::__construct();
        $this->chipsetParts = new ArrayCollection();
        $this->documentations = new ArrayCollection();
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
            return "$this->partNumber ($this->name)";
        } else {
            return "$this->partNumber";
        }
    }
    public function getShortNamePN(): ?string
    {
        return "$this->partNumber";
    }
    /**
     * @return Collection|ChipDocumentation[]
     */
    public function getDocumentations(): Collection
    {
        return $this->documentations;
    }
    public function addManual(ChipDocumentation $documentation): self
    {
        if (!$this->documentations->contains($documentation)) {
            $this->documentations[] = $documentation;
            $documentation->setChip($this);
        }

        return $this;
    }
    public function removeManual(ChipDocumentation $documentation): self
    {
        if ($this->documentations->contains($documentation)) {
            $this->documentations->removeElement($documentation);
            // set the owning side to null (unless already changed)
            if ($documentation->getChip() === $this) {
                $documentation->setChip(null);
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
    public function getRank(): ?int
    {
        return $this->rank;
    }
    public function setRank(int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }
}
