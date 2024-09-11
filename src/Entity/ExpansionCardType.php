<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ExpansionCardTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpansionCardTypeRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['expansion_card_type:read']]),
        new Get(normalizationContext: ['groups' => ['expansion_card_type:read']]),
        new Post(denormalizationContext: ['groups' => ['expansion_card_type:write']]),
        new Put(denormalizationContext: ['groups' => ['expansion_card_type:write']]),
        new Delete()
    ]
)]
class ExpansionCardType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['expansion_card_type:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['expansion_card_type:read','expansion_card_type:write'])]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: ExpansionCard::class, mappedBy: 'type')]
    private Collection $expansionCards;

    #[ORM\Column(type: Types::JSON, options: ['jsonb' => true])]
    private array $template = [];

    public function __construct()
    {
        $this->expansionCards = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->name;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCard>
     */
    public function getExpansionCards(): Collection
    {
        return $this->expansionCards;
    }

    public function addExpansionCard(ExpansionCard $expansionCard): static
    {
        if (!$this->expansionCards->contains($expansionCard)) {
            $this->expansionCards->add($expansionCard);
            $expansionCard->addType($this);
        }

        return $this;
    }

    public function removeExpansionCard(ExpansionCard $expansionCard): static
    {
        if ($this->expansionCards->removeElement($expansionCard)) {
            $expansionCard->removeType($this);
        }

        return $this;
    }

    public function getTemplate(): array
    {
        return $this->template;
    }

    public function setTemplate(array $template): static
    {
        $this->template = $template;

        return $this;
    }
    public function getTemplateAsText(): string
    {
        return json_encode($this->template, \JSON_PARTIAL_OUTPUT_ON_ERROR);
    }
}
