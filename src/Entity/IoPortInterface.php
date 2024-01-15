<?php

namespace App\Entity;

use App\Repository\IoPortInterfaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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

    public function __construct()
    {
        $this->expansionCardIoPorts = new ArrayCollection();
        $this->ioPortSignals = new ArrayCollection();
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
}
