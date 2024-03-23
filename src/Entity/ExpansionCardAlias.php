<?php

namespace App\Entity;

use App\Repository\ExpansionCardAliasRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpansionCardAliasRepository::class)]
class ExpansionCardAlias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardAliases')]
    private ?Manufacturer $manufacturer = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardAliases')]
    private ?ExpansionCard $expansionCard = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Alias name is longer than {{ limit }} characters.')]
    #[Assert\NotBlank(message: 'Alias name cannot be blank')]
    private ?string $name = null;

    public function __toString(): string
    {
        return $this->getFullAliasName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): static
    {
        $this->manufacturer = $manufacturer;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
    public function getFullAliasName(): string
    {
        $fullName = $this->name;
        if ($this->getManufacturer()) {
            $fullName = $this->getManufacturer()->getName() . " " . $fullName;
        } else {
            $fullName = "Unknown " . $fullName;
        }
        return "$fullName";
    }
}
