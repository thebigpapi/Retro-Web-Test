<?php

namespace App\Entity;

use App\Repository\ExpansionCardBiosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpansionCardBiosRepository::class)]
class ExpansionCardBios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $version = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardBios')]
    private ?ExpansionCard $expansionCard = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): static
    {
        $this->version = $version;

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
}
