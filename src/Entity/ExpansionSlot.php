<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ExpansionSlotRepository')]
class ExpansionSlot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\OneToMany(targetEntity: MotherboardExpansionSlot::class, mappedBy: 'expansion_slot', orphanRemoval: true)]
    private $motherboardExpansionSlots;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Assert\Positive(message: "Slot ID should be greater than 0")]
    private ?int $cardId = null;
    public function __construct()
    {
        $this->motherboardExpansionSlots = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getName();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return Collection|MotherboardExpansionSlot[]
     */
    public function getMotherboardExpansionSlots(): Collection
    {
        return $this->motherboardExpansionSlots;
    }
    public function addMotherboardExpansionSlot(MotherboardExpansionSlot $motherboardExpansionSlot): self
    {
        if (!$this->motherboardExpansionSlots->contains($motherboardExpansionSlot)) {
            $this->motherboardExpansionSlots[] = $motherboardExpansionSlot;
            $motherboardExpansionSlot->setExpansionSlot($this);
        }

        return $this;
    }
    public function removeMotherboardExpansionSlot(MotherboardExpansionSlot $motherboardExpansionSlot): self
    {
        if ($this->motherboardExpansionSlots->contains($motherboardExpansionSlot)) {
            $this->motherboardExpansionSlots->removeElement($motherboardExpansionSlot);
            // set the owning side to null (unless already changed)
            if ($motherboardExpansionSlot->getExpansionSlot() === $this) {
                $motherboardExpansionSlot->setExpansionSlot(null);
            }
        }
        return $this;
    }

    public function getCardId(): ?int
    {
        return $this->cardId;
    }

    public function setCardId(?int $cardId): static
    {
        $this->cardId = $cardId;

        return $this;
    }
}
