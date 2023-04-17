<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExpansionChipTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpansionChipTypeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'read:ExpansionChip:item'],
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => ['read:ExpansionChipType:list', 'related']]],
        'post' => ['denormalization_context' => ['groups' => 'write:ExpansionChipType']]
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:ExpansionChipType:item']],
        'put' => ['denormalization_context' => ['groups' => 'write:ExpansionChipType']],
        'delete'
    ],
    order: ['name' => 'ASC'],
    paginationEnabled: false,
)]
class ExpansionChipType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:ExpansionChipType:list', 'read:ExpansionChipType:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max:255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    #[Groups(['read:ExpansionChipType:list', 'read:ExpansionChipType:item', 'write:ExpansionChipType'])]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: ExpansionChip::class, mappedBy: 'type', orphanRemoval: true, cascade: ['persist'])]
    private $expansionChips;

    public function __construct()
    {
        $this->expansionChips = new ArrayCollection();
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
}
