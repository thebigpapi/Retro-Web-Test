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

    #[ORM\ManyToOne(inversedBy: 'ioPortSignals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?IoPortInterface $interface = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'ioPortInterfaceSignal', targetEntity: ExpansionCardIoPort::class)]
    private Collection $expansionCardIoPorts;

    #[ORM\ManyToMany(targetEntity: IoPortSignal::class, inversedBy: 'ioPortInterfaceSignals')]
    private Collection $signals;


    public function __toString()
    {
        return $this->name ?? ($this->interface->getName() . " (" . $this->getNameAllSignals()) .")";
    }

    public function __construct()
    {
        $this->expansionCardIoPorts = new ArrayCollection();
        $this->signals = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'signal'=> $this->getSignalIds(),
            'interface'=> $this->interface->getId(),

        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getSignalIds(): ?array
    {
        $signals = [];
        foreach($this->signals as $signal){
            array_push($signals, $signal->getId());
        }
        return $signals;
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
    public function getNameAllSignals(): string
    {
        $name = "";
        foreach($this->signals as $signal){
            $name .= $signal . ", ";
        }
        return substr($name, 0, -2);
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

    /**
     * @return Collection<int, IoPortSignal>
     */
    public function getSignals(): Collection
    {
        return $this->signals;
    }

    public function addSignal(IoPortSignal $signal): static
    {
        if (!$this->signals->contains($signal)) {
            $this->signals->add($signal);
        }

        return $this;
    }

    public function removeSignal(IoPortSignal $signal): static
    {
        $this->signals->removeElement($signal);

        return $this;
    }
    public function getAllDocs(): Collection
    {
        $docs = $this->getInterface()->getEntityDocumentations()->toArray() ?? [];
        foreach ($this->getSignals() as $signal) {
            $docs = array_merge($docs, $signal->getEntityDocumentations()->toArray());
        }
        return new ArrayCollection($docs);
    }
    public function getAllImages(): Collection
    {
        $img = $this->getInterface()->getEntityImages()->toArray() ?? [];
        foreach ($this->getSignals() as $signal) {
            $img = array_merge($img, $signal->getEntityImages()->toArray());
        }
        return new ArrayCollection($img);
    }
}
