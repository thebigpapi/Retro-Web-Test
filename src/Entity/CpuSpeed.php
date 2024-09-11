<?php

namespace App\Entity;

use App\Repository\CpuSpeedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CpuSpeedRepository::class)]
class CpuSpeed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Assert\PositiveOrZero]
    private $value;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'cpuSpeed')]
    private $motherboards;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getValueWithUnit();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getValueWithUnit(): ?string
    {
        return $this->value . 'MHz';
    }
    public function getValue(): ?float
    {
        return $this->value;
    }
    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }
    /**
     * @return Collection|Motherboard[]
     */
    public function getMotherboards(): Collection
    {
        return $this->motherboards;
    }
    public function addMotherboard(Motherboard $motherboard): self
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->addCpuSpeed($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            $motherboard->removeCpuSpeed($this);
        }

        return $this;
    }
}
