<?php

namespace App\Entity;

use App\Repository\IoPortInterfaceSignalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IoPortInterfaceSignalRepository::class)]
class IoPortInterfaceSignal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ioPortInterfaces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?IoPortSignal $signal = null;

    #[ORM\ManyToOne(inversedBy: 'ioPortSignals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?IoPortInterface $interface = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'ioPortInterfaceSignal', targetEntity: ExpansionCardIoPort::class)]
    private Collection $expansionCardIoPorts;


    public function __toString()
    {
        return $this->name ?? ($this->interface->getName() . " (" . $this->signal->getName()) .")";
    }

    public function __construct()
    {
        $this->expansionCardIoPorts = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'signal'=> $this->signal->getId(),
            'interface'=> $this->interface->getId(),

        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSignal(): ?IoPortSignal
    {
        return $this->signal;
    }

    public function setSignal(?IoPortSignal $signal): static
    {
        $this->signal = $signal;

        return $this;
    }

    public function getInterface(): ?IoPortInterface
    {
        return $this->interface;
    }

    public function setInterface(?IoPortInterface $interface): static
    {
        $this->interface = $interface;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

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
            $expansionCardIoPort->setIoPortInterfaceSignal($this);
        }

        return $this;
    }

    public function removeExpansionCardIoPort(ExpansionCardIoPort $expansionCardIoPort): static
    {
        if ($this->expansionCardIoPorts->removeElement($expansionCardIoPort)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardIoPort->getIoPortInterfaceSignal() === $this) {
                $expansionCardIoPort->setIoPortInterfaceSignal(null);
            }
        }

        return $this;
    }
}
