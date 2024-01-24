<?php

namespace App\Entity;

use App\Repository\ExpansionCardMemoryConnectorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpansionCardMemoryConnectorRepository::class)]
class ExpansionCardMemoryConnector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardMemoryConnectors')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExpansionCard $expansionCard = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardMemoryConnectors')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:'Memory connector type cannot be blank')]
    private ?MemoryConnector $memoryConnector = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero(message: "Memory connector count should be 0 or above")]
    #[Assert\LessThan(100, message: "Memory connector count should be below 100")]
    #[Assert\NotBlank(message:'Memory connector count cannot be blank')]
    private ?int $count = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpansionCard(): ?ExpansionCard
    {
        return $this->expansionCard;
    }

    public function setExpansionCard(?ExpansionCard $expansionCard): static
    {
        $this->expansionCard = $expansionCard;

        return $this;
    }

    public function getMemoryConnector(): ?MemoryConnector
    {
        return $this->memoryConnector;
    }

    public function setMemoryConnector(?MemoryConnector $memoryConnector): static
    {
        $this->memoryConnector = $memoryConnector;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): static
    {
        $this->count = $count;

        return $this;
    }
}
