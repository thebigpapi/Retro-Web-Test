<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\MotherboardExpansionSlotRepository;

#[ORM\Entity(repositoryClass: MotherboardExpansionSlotRepository::class)]
class MotherboardExpansionSlot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Motherboard::class, inversedBy: 'motherboardExpansionSlots')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;

    #[ORM\ManyToOne(targetEntity: ExpansionSlot::class, inversedBy: 'motherboardExpansionSlots')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:'Expansion slot type cannot be blank')]
    private $expansion_slot;

    #[Assert\Positive(message: "Expansion slot count should be above 0")]
    #[Assert\LessThan(100, message: "Expansion slot count should be below 100")]
    #[Assert\NotBlank(message:'Expansion slot count cannot be blank')]
    #[ORM\Column(type: 'integer')]
    private $count;

    public function __toString(): string
    {
        $expname = $this->getExpansionSlot();
        if(isset($expname))
            return $this->getExpansionSlot()->getName();
        else return "";
    }
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
