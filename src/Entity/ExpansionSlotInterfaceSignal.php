<?php

namespace App\Entity;

use App\Repository\ExpansionSlotInterfaceSignalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpansionSlotInterfaceSignalRepository::class)]
class ExpansionSlotInterfaceSignal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: ExpansionSlotSignal::class, inversedBy: 'expansionSlotInterfaceSignals')]
    private Collection $signals;

    #[ORM\ManyToOne(inversedBy: 'expansionSlotInterfaceSignals')]
    #[Assert\NotBlank(
        message: 'Connector cannot be blank'
    )]
    private ?ExpansionSlotInterface $interface = null;

    #[ORM\OneToMany(mappedBy: 'expansionSlotInterfaceSignal', targetEntity: ExpansionCard::class)]
    private Collection $expansionCards;

    public function __construct()
    {
        $this->signals = new ArrayCollection();
        $this->expansionCards = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->name;
    }
    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'signals'=> $this->getSignalArray(),
            'interfaceId'=> $this->interface->getId(),
            'interfaceName'=> $this->interface->getName(),
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getSignalArray(): ?array
    {
        $signals = [];
        foreach($this->signals as $signal){
            $signals[$signal->getId()] = $signal->getName();
        }
        return $signals;
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
     * @return Collection<int, ExpansionSlotSignal>
     */
    public function getSignals(): Collection
    {
        return $this->signals;
    }

    public function addSignal(ExpansionSlotSignal $signal): static
    {
        if (!$this->signals->contains($signal)) {
            $this->signals->add($signal);
        }

        return $this;
    }

    public function removeSignal(ExpansionSlotSignal $signal): static
    {
        $this->signals->removeElement($signal);

        return $this;
    }

    public function getInterface(): ?ExpansionSlotInterface
    {
        return $this->interface;
    }

    public function setInterface(?ExpansionSlotInterface $interface): static
    {
        $this->interface = $interface;

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
            $expansionCard->setExpansionSlotInterfaceSignal($this);
        }

        return $this;
    }

    public function removeExpansionCard(ExpansionCard $expansionCard): static
    {
        if ($this->expansionCards->removeElement($expansionCard)) {
            // set the owning side to null (unless already changed)
            if ($expansionCard->getExpansionSlotInterfaceSignal() === $this) {
                $expansionCard->setExpansionSlotInterfaceSignal(null);
            }
        }

        return $this;
    }
    public function getAllDocs(): Collection
    {
        $docs = $this->getInterface()?->getEntityDocumentations()->toArray() ?? [];
        foreach ($this->getSignals() as $signal) {
            $docs = array_merge($docs, $signal->getEntityDocumentations()->toArray());
        }
        return new ArrayCollection($docs);
    }
    public function getAllImages(): Collection
    {
        $img = $this->getInterface()?->getEntityImages()->toArray() ?? [];
        foreach ($this->getSignals() as $signal) {
            $img = array_merge($img, $signal->getEntityImages()->toArray());
        }
        return new ArrayCollection($img);
    }
}
