<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ChipsetPartRepository')]
class ChipsetPart extends Chip
{
    #[ORM\ManyToMany(targetEntity: Chipset::class, mappedBy: 'chipsetParts')]
    private $chipsets;

    #[ORM\Column(type: 'string', length: 8192, nullable: true)]
    #[Assert\Length(max:8192, maxMessage: 'Description is longer than {{ limit }} characters, try to make it shorter.')]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $rank;

    public function __construct()
    {
        parent::__construct();
        $this->chipsets = new ArrayCollection();
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
