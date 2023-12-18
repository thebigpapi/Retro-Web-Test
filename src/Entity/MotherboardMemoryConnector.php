<?php

namespace App\Entity;

use App\Repository\MotherboardMemoryConnectorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MotherboardMemoryConnectorRepository::class)]
class MotherboardMemoryConnector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'motherboardMemoryConnectors')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Motherboard $motherboard = null;

    #[ORM\ManyToOne(inversedBy: 'motherboardMemoryConnectors')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:'Memory connector type cannot be blank')]
    private ?MemoryConnector $memoryConnector = null;

    #[Assert\PositiveOrZero(message: "Memory connector count should be 0 or above")]
    #[Assert\LessThan(100, message: "Memory connector count should be below 100")]
    #[Assert\NotBlank(message:'Memory connector count cannot be blank')]
    #[ORM\Column(type: 'integer')]
    private ?int $count = null;

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

    public function getMemoryConnector(): ?MemoryConnector
    {
        return $this->memoryConnector;
    }

    public function setMemoryConnector(?MemoryConnector $memoryConnector): self
    {
        $this->memoryConnector = $memoryConnector;

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
