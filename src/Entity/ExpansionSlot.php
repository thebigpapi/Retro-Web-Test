<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExpansionSlotRepository")
 */
class ExpansionSlot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MotherboardExpansionSlot", mappedBy="expansion_slot", orphanRemoval=true)
     */
    private $motherboardExpansionSlots;

    public function __construct()
    {
        $this->motherboardExpansionSlots = new ArrayCollection();
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
}
