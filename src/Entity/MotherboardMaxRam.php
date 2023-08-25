<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\MotherboardMaxRamRepository')]
class MotherboardMaxRam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Motherboard::class, inversedBy: 'motherboardMaxRams')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;

    #[ORM\ManyToOne(targetEntity: MaxRam::class, inversedBy: 'motherboardMaxRams')]
    #[ORM\JoinColumn(nullable: false)]
    private $max_ram;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 40, maxMessage: 'RAM note is longer than {{ limit }} characters.')]

    private $note;

    public function __toString(): string
    {
        return $this->getMaxRam()->getValueWithUnit();
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
    public function getMaxram(): ?MaxRam
    {
        return $this->max_ram;
    }
    public function setMaxram(?MaxRam $max_ram): self
    {
        $this->max_ram = $max_ram;

        return $this;
    }
    public function getNote(): ?string
    {
        return $this->note;
    }
    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
