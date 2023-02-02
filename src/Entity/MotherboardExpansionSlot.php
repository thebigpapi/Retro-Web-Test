<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\MotherboardExpansionSlotRepository')]
class MotherboardExpansionSlot
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Motherboard::class, inversedBy: 'motherboardExpansionSlots')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;
    
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: ExpansionSlot::class, inversedBy: 'motherboardExpansionSlots')]
    #[ORM\JoinColumn(nullable: false)]
    private $expansion_slot;

    #[ORM\Column(type: 'integer')]
    private $count;

    public function getMotherboard(): ?Motherboard
    {
        return $this->motherboard;
    }
    public function setMotherboard(?Motherboard $motherboard): self
    {
        $this->motherboard = $motherboard;

        return $this;
    }
    public function getExpansionSlot(): ?ExpansionSlot
    {
        return $this->expansion_slot;
    }
    public function setExpansionSlot(?ExpansionSlot $expansion_slot): self
    {
        $this->expansion_slot = $expansion_slot;

        return $this;
    }
    public function getCount(): ?int
    {
        return $this->count;
    }
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
