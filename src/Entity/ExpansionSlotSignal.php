<?php

namespace App\Entity;

use App\Repository\ExpansionSlotSignalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpansionSlotSignalRepository::class)]
class ExpansionSlotSignal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'expansionSlotSignal', targetEntity: ExpansionCard::class)]
    private Collection $expansionCards;

    #[ORM\ManyToMany(targetEntity: ExpansionSlotInterfaceSignal::class, mappedBy: 'signals')]
    private Collection $expansionSlotInterfaceSignals;

    #[ORM\OneToMany(mappedBy: 'expansionSlotSignal', targetEntity: EntityImage::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $entityImages;

    #[ORM\OneToMany(mappedBy: 'expansionSlotSignal', targetEntity: EntityDocumentation::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $entityDocumentations;

    #[ORM\Column(length: 4096, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->expansionCards = new ArrayCollection();
        $this->expansionSlotInterfaceSignals = new ArrayCollection();
        $this->entityImages = new ArrayCollection();
        $this->entityDocumentations = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $expansionCard->setExpansionSlotSignal($this);
        }

        return $this;
    }

    public function removeExpansionCard(ExpansionCard $expansionCard): static
    {
        if ($this->expansionCards->removeElement($expansionCard)) {
            // set the owning side to null (unless already changed)
            if ($expansionCard->getExpansionSlotSignal() === $this) {
                $expansionCard->setExpansionSlotSignal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExpansionSlotInterfaceSignal>
     */
    public function getExpansionSlotInterfaceSignals(): Collection
    {
        return $this->expansionSlotInterfaceSignals;
    }

    public function addExpansionSlotInterfaceSignal(ExpansionSlotInterfaceSignal $expansionSlotInterfaceSignal): static
    {
        if (!$this->expansionSlotInterfaceSignals->contains($expansionSlotInterfaceSignal)) {
            $this->expansionSlotInterfaceSignals->add($expansionSlotInterfaceSignal);
            $expansionSlotInterfaceSignal->addSignal($this);
        }

        return $this;
    }

    public function removeExpansionSlotInterfaceSignal(ExpansionSlotInterfaceSignal $expansionSlotInterfaceSignal): static
    {
        if ($this->expansionSlotInterfaceSignals->removeElement($expansionSlotInterfaceSignal)) {
            $expansionSlotInterfaceSignal->removeSignal($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, EntityImage>
     */
    public function getEntityImages(): Collection
    {
        return $this->entityImages;
    }

    public function addEntityImage(EntityImage $entityImage): static
    {
        if (!$this->entityImages->contains($entityImage)) {
            $this->entityImages->add($entityImage);
            $entityImage->setExpansionSlotSignal($this);
        }

        return $this;
    }

    public function removeEntityImage(EntityImage $entityImage): static
    {
        if ($this->entityImages->removeElement($entityImage)) {
            // set the owning side to null (unless already changed)
            if ($entityImage->getExpansionSlotSignal() === $this) {
                $entityImage->setExpansionSlotSignal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EntityDocumentation>
     */
    public function getEntityDocumentations(): Collection
    {
        return $this->entityDocumentations;
    }

    public function addEntityDocumentation(EntityDocumentation $entityDocumentation): static
    {
        if (!$this->entityDocumentations->contains($entityDocumentation)) {
            $this->entityDocumentations->add($entityDocumentation);
            $entityDocumentation->setExpansionSlotSignal($this);
        }

        return $this;
    }

    public function removeEntityDocumentation(EntityDocumentation $entityDocumentation): static
    {
        if ($this->entityDocumentations->removeElement($entityDocumentation)) {
            // set the owning side to null (unless already changed)
            if ($entityDocumentation->getExpansionSlotSignal() === $this) {
                $entityDocumentation->setExpansionSlotSignal(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
