<?php

namespace App\Entity;

use App\Repository\ExpansionChipTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpansionChipTypeRepository::class)]
class ExpansionChipType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max:255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Chip::class, mappedBy: 'type', orphanRemoval: true, cascade: ['persist'])]
    private $chips;

    #[ORM\Column(type: Types::JSON, options: ['jsonb' => true])]
    private array $template = [];

    public function __construct()
    {
        $this->chips = new ArrayCollection();
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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Chip[]
     */
    public function getChips(): Collection
    {
        return $this->chips;
    }
    public function addChip(Chip $chip): self
    {
        if (!$this->chips->contains($chip)) {
            $this->chips[] = $chip;
            $chip->setType($this);
        }

        return $this;
    }
    public function removeChip(Chip $chip): self
    {
        if ($this->chips->contains($chip)) {
            $this->chips->removeElement($chip);
            // set the owning side to null (unless already changed)
            if ($chip->getType() === $this) {
                $chip->setType(null);
            }
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
