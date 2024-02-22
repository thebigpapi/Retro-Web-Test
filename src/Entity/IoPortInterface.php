<?php

namespace App\Entity;

use App\Repository\IoPortInterfaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IoPortInterfaceRepository::class)]
class IoPortInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'ioPortInterface', targetEntity: ExpansionCardIoPort::class)]
    private Collection $expansionCardIoPorts;

    #[ORM\OneToMany(mappedBy: 'interface', targetEntity: IoPortInterfaceSignal::class)]
    private Collection $ioPortSignals;

    #[ORM\OneToMany(mappedBy: 'ioPortInterface', targetEntity: EntityImage::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $entityImages;

    #[ORM\OneToMany(mappedBy: 'ioPortInterface', targetEntity: EntityDocumentation::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $entityDocumentations;

    #[ORM\Column(length: 4096, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $partNumber = null;

    public function __construct()
    {
        $this->expansionCardIoPorts = new ArrayCollection();
        $this->ioPortSignals = new ArrayCollection();
        $this->entityImages = new ArrayCollection();
        $this->entityDocumentations = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
        ];
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
     * @return Collection<int, ExpansionCardIoPort>
     */
    public function getExpansionCardIoPorts(): Collection
    {
        return $this->expansionCardIoPorts;
    }

    public function addExpansionCardIoPort(ExpansionCardIoPort $expansionCardIoPort): static
    {
        if (!$this->expansionCardIoPorts->contains($expansionCardIoPort)) {
            $this->expansionCardIoPorts->add($expansionCardIoPort);
            $expansionCardIoPort->setIoPortInterface($this);
        }

        return $this;
    }

    public function removeExpansionCardIoPort(ExpansionCardIoPort $expansionCardIoPort): static
    {
        if ($this->expansionCardIoPorts->removeElement($expansionCardIoPort)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardIoPort->getIoPortInterface() === $this) {
                $expansionCardIoPort->setIoPortInterface(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, IoPortInterfaceSignal>
     */
    public function getIoPortSignals(): Collection
    {
        return $this->ioPortSignals;
    }

    public function addIoPortSignal(IoPortInterfaceSignal $ioPortSignal): static
    {
        if (!$this->ioPortSignals->contains($ioPortSignal)) {
            $this->ioPortSignals->add($ioPortSignal);
            $ioPortSignal->setInterface($this);
        }

        return $this;
    }

    public function removeElectricalInterface(IoPortInterfaceSignal $ioPortSignal): static
    {
        if ($this->ioPortSignals->removeElement($ioPortSignal)) {
            // set the owning side to null (unless already changed)
            if ($ioPortSignal->getInterface() === $this) {
                $ioPortSignal->setInterface(null);
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
            $entityImage->setIoPortInterface($this);
        }

        return $this;
    }

    public function removeEntityImage(EntityImage $entityImage): static
    {
        if ($this->entityImages->removeElement($entityImage)) {
            // set the owning side to null (unless already changed)
            if ($entityImage->getIoPortInterface() === $this) {
                $entityImage->setIoPortInterface(null);
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
            $entityDocumentation->setIoPortInterface($this);
        }

        return $this;
    }

    public function removeEntityDocumentation(EntityDocumentation $entityDocumentation): static
    {
        if ($this->entityDocumentations->removeElement($entityDocumentation)) {
            // set the owning side to null (unless already changed)
            if ($entityDocumentation->getIoPortInterface() === $this) {
                $entityDocumentation->setIoPortInterface(null);
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

    public function getPartNumber(): ?string
    {
        return $this->partNumber;
    }

    public function setPartNumber(?string $partNumber): static
    {
        $this->partNumber = $partNumber;

        return $this;
    }
}
