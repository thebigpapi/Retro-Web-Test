<?php

namespace App\Entity;

use App\Repository\ExpansionConnectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpansionConnectorRepository::class)
 */
class ExpansionConnector
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ExpansionSlot::class, mappedBy="connector")
     */
    private $expansionSlots;

    public function __construct()
    {
        $this->expansionSlots = new ArrayCollection();
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
     * @return Collection|ExpansionSlot[]
     */
    public function getExpansionSlots(): Collection
    {
        return $this->expansionSlots;
    }

    public function addExpansionSlot(ExpansionSlot $expansionSlot): self
    {
        if (!$this->expansionSlots->contains($expansionSlot)) {
            $this->expansionSlots[] = $expansionSlot;
            $expansionSlot->setConnector($this);
        }

        return $this;
    }

    public function removeExpansionSlot(ExpansionSlot $expansionSlot): self
    {
        if ($this->expansionSlots->removeElement($expansionSlot)) {
            // set the owning side to null (unless already changed)
            if ($expansionSlot->getConnector() === $this) {
                $expansionSlot->setConnector(null);
            }
        }

        return $this;
    }
}
