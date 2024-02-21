<?php

namespace App\Entity;

use App\Repository\ExpansionSlotInterfaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpansionSlotInterfaceRepository::class)]
class ExpansionSlotInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'interface', targetEntity: ExpansionSlotInterfaceSignal::class)]
    private Collection $expansionSlotInterfaceSignals;

    #[ORM\OneToMany(mappedBy: 'expansionSlotInterface', targetEntity: EntityImage::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $entityImages;

    #[ORM\OneToMany(mappedBy: 'expansionSlotInterface', targetEntity: EntityDocumentation::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $entityDocumentations;

    #[ORM\Column(length: 4096, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
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
     * @return Collection<int, ExpansionSlotInterfaceSignal>
     */
    public function getExpansionSlotInterfaceSignals(): Collection
    {
        return $this->expansionSlotInterfaceSignals;
    }

    public function addExpansionCardSlot(ExpansionSlotInterfaceSignal $expansionCardSlot): static
    {
        if (!$this->expansionSlotInterfaceSignals->contains($expansionCardSlot)) {
            $this->expansionSlotInterfaceSignals->add($expansionCardSlot);
            $expansionCardSlot->setInterface($this);
        }

        return $this;
    }

    public function removeExpansionCardSlot(ExpansionSlotInterfaceSignal $expansionCardSlot): static
    {
        if ($this->expansionSlotInterfaceSignals->removeElement($expansionCardSlot)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardSlot->getInterface() === $this) {
                $expansionCardSlot->setInterface(null);
            }
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
            $entityImage->setExpansionSlotInterface($this);
        }

        return $this;
    }

    public function removeEntityImage(EntityImage $entityImage): static
    {
        if ($this->entityImages->removeElement($entityImage)) {
            // set the owning side to null (unless already changed)
            if ($entityImage->getExpansionSlotInterface() === $this) {
                $entityImage->setExpansionSlotInterface(null);
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
            $entityDocumentation->setExpansionSlotInterface($this);
        }

        return $this;
    }

    public function removeEntityDocumentation(EntityDocumentation $entityDocumentation): static
    {
        if ($this->entityDocumentations->removeElement($entityDocumentation)) {
            // set the owning side to null (unless already changed)
            if ($entityDocumentation->getExpansionSlotInterface() === $this) {
                $entityDocumentation->setExpansionSlotInterface(null);
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
