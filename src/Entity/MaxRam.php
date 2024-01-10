<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: 'App\Repository\MaxRamRepository')]
class MaxRam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'bigint')]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    #[Assert\Unique()]
    private $value;

    #[ORM\OneToMany(targetEntity: MotherboardMaxRam::class, mappedBy: 'max_ram', orphanRemoval: true)]
    private $motherboardMaxRams;

    #[ORM\OneToMany(targetEntity: Motherboard::class, mappedBy: 'maxVideoRam')]
    private $motherboards;

    #[ORM\ManyToMany(targetEntity: ExpansionCard::class, mappedBy: 'ramSize')]
    private Collection $expansionCards;

    public function __construct()
    {
        $this->motherboardMaxRams = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
        $this->expansionCards = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getValueWithUnit();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getValueWithUnit(): ?string
    {
        if ($this->value >= (1024 * 1024)) {
            return round($this->value / (1024 * 1024), 2) . 'GB';
        } elseif ($this->value >= 1024) {
            return round($this->value / 1024, 2) . 'MB';
        } else {
            return $this->value . 'KB';
        }
    }
    public function getValue(): ?int
    {
        return $this->value;
    }
    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
    /**
     * @return Collection|MotherboardMaxRam[]
     */
    public function getMotherboardMaxRams(): Collection
    {
        return $this->motherboardMaxRams;
    }
    public function addMotherboardMaxRam(MotherboardMaxRam $motherboardMaxRam): self
    {
        if (!$this->motherboardMaxRams->contains($motherboardMaxRam)) {
            $this->motherboardMaxRams[] = $motherboardMaxRam;
            $motherboardMaxRam->setMaxram($this);
        }

        return $this;
    }
    public function removeMotherboardMaxRam(MotherboardMaxRam $motherboardMaxRam): self
    {
        if ($this->motherboardMaxRams->contains($motherboardMaxRam)) {
            $this->motherboardMaxRams->removeElement($motherboardMaxRam);
            // set the owning side to null (unless already changed)
            if ($motherboardMaxRam->getMaxram() === $this) {
                $motherboardMaxRam->setMaxram(null);
            }
        }

        return $this;
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
            $motherboard->setMaxVideoRam($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            // set the owning side to null (unless already changed)
            if ($motherboard->getMaxVideoRam() === $this) {
                $motherboard->setMaxVideoRam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCard>
     */
    public function getExpansionCards(): Collection
    {
        return $this->expansionCards;
    }

    public function addExpansionCard(ExpansionCard $expansionCard): static
    {
        if (!$this->expansionCards->contains($expansionCard)) {
            $this->expansionCards->add($expansionCard);
            $expansionCard->addRamSize($this);
        }

        return $this;
    }

    public function removeExpansionCard(ExpansionCard $expansionCard): static
    {
        if ($this->expansionCards->removeElement($expansionCard)) {
            $expansionCard->removeRamSize($this);
        }

        return $this;
    }
}
