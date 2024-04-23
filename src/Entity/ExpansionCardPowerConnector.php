<?php

namespace App\Entity;

use App\Repository\ExpansionCardPowerConnectorRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: ExpansionCardPowerConnectorRepository::class)]
class ExpansionCardPowerConnector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Positive(message: "> 0!")]
    #[Assert\LessThan(100, message: "< 100!")]
    #[Assert\NotBlank(message:'Blank!')]
    #[ORM\Column]
    private ?int $count = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardPowerConnectors')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:'I/O port connector cannot be blank')]
    private ?PSUConnector $powerConnector = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardPowerConnectors')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExpansionCard $expansionCard = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): static
    {
        $this->count = $count;

        return $this;
    }

    public function getPowerConnector(): ?PSUConnector
    {
        return $this->powerConnector;
    }

    public function setPowerConnector(?PSUConnector $powerConnector): static
    {
        $this->powerConnector = $powerConnector;

        return $this;
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
    #[Assert\Callback]
    public function autosetCountIfEmpty(): void
    {
        if(null === $this->count && null !== $this->powerConnector) {
            $this->count = 1;
        }
    }
}
