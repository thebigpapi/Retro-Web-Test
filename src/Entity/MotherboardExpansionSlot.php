<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MotherboardExpansionSlotRepository")
 */
class MotherboardExpansionSlot
{ 
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Motherboard", inversedBy="motherboardExpansionSlots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $motherboard;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\ExpansionSlot", inversedBy="motherboardExpansionSlots")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:motherboard:item"})
     */
    private $expansion_slot;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:motherboard:item"})
     */
    private $count;

    public function getId(): ?int
    {
        return $this->id;
    }

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
