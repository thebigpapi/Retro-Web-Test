<?php

namespace App\Entity;

use App\Repository\ExpansionChipTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    #[Assert\Length(max:255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: ExpansionChip::class, mappedBy: 'type', orphanRemoval: true, cascade: ['persist'])]
    private $expansionChips;

    #[ORM\Column]
    private array $template = [];

    public function __construct()
    {
        $this->expansionChips = new ArrayCollection();
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
     * @return Collection|ExpansionChip[]
     */
    public function getExpansionChips(): Collection
    {
        return $this->expansionChips;
    }
    public function addExpansionChip(ExpansionChip $expansionChip): self
    {
        if (!$this->expansionChips->contains($expansionChip)) {
            $this->expansionChips[] = $expansionChip;
            $expansionChip->setExpansionChipType($this);
        }

        return $this;
    }
    public function removeExpansionChip(ExpansionChip $expansionChip): self
    {
        if ($this->expansionChips->contains($expansionChip)) {
            $this->expansionChips->removeElement($expansionChip);
            // set the owning side to null (unless already changed)
            if ($expansionChip->getExpansionChipType() === $this) {
                $expansionChip->setExpansionChipType(null);
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
