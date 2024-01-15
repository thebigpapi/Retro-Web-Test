<?php

namespace App\Entity;

use App\Repository\IoPortSignalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IoPortSignalRepository::class)]
class IoPortSignal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: ExpansionCardIoPort::class, mappedBy: 'ioPortSignals')]
    private Collection $expansionCards;

    #[ORM\OneToMany(mappedBy: 'signal', targetEntity: IoPortInterfaceSignal::class)]
    private Collection $ioPortInterfaces;

    public function __construct()
    {
        $this->expansionCards = new ArrayCollection();
        $this->ioPortInterfaces = new ArrayCollection();
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
     * @return Collection<int, ExpansionCardIoPort>
     */
    public function getExpansionCards(): Collection
    {
        return $this->expansionCards;
    }

    public function addExpansionCard(ExpansionCardIoPort $expansionCard): static
    {
        if (!$this->expansionCards->contains($expansionCard)) {
            $this->expansionCards->add($expansionCard);
            $expansionCard->addIoPortSignal($this);
        }

        return $this;
    }

    public function removeExpansionCard(ExpansionCardIoPort $expansionCard): static
    {
        if ($this->expansionCards->removeElement($expansionCard)) {
            $expansionCard->removeIoPortSignal($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, IoPortInterfaceSignal>
     */
    public function getIoPortInterfaces(): Collection
    {
        return $this->ioPortInterfaces;
    }

    public function addIoPortInterface(IoPortInterfaceSignal $ioPortInterface): static
    {
        if (!$this->ioPortInterfaces->contains($ioPortInterface)) {
            $this->ioPortInterfaces->add($ioPortInterface);
            $ioPortInterface->setElectrical($this);
        }

        return $this;
    }

    public function removeIoPortInterface(IoPortInterfaceSignal $ioPortInterface): static
    {
        if ($this->ioPortInterfaces->removeElement($ioPortInterface)) {
            // set the owning side to null (unless already changed)
            if ($ioPortInterface->getElectrical() === $this) {
                $ioPortInterface->setElectrical(null);
            }
        }

        return $this;
    }
}
