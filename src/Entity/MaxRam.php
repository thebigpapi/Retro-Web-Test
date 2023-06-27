<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use App\Repository\MaxRamRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[
    ApiResource(
        operations: [
            new Get(normalizationContext: ['groups' => 'read:MaxRam:item']),
            new Put(denormalizationContext: ['groups' => 'write:MaxRam']),
            new Delete(),
            new GetCollection(normalizationContext: ['groups' => 'read:MaxRam:list']),
            new Post(denormalizationContext: ['groups' => 'write:MaxRam'])
        ],
        normalizationContext: ['groups' => 'read:MaxRam:item'],
        order: ['value' => 'ASC'],
        paginationEnabled: false
    )
]
#[ORM\Entity(repositoryClass: MaxRamRepository::class)]
#[UniqueEntity('value')]
class MaxRam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:MaxRam:list', 'read:MaxRam:item'])]
    private $id;

    #[ORM\Column(type: 'bigint')]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    #[Groups(['read:MaxRam:list', 'read:MaxRam:item', 'write:MaxRam'])]
    private $value;

    #[ORM\OneToMany(targetEntity: MotherboardMaxRam::class, mappedBy: 'max_ram', orphanRemoval: true)]
    private $motherboardMaxRams;

    #[ORM\OneToMany(targetEntity: Motherboard::class, mappedBy: 'maxVideoRam')]
    private $motherboards;

    public function __construct()
    {
        $this->motherboardMaxRams = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getValueWithUnit(): ?string
    {
        if ($this->value >= (1024 * 1024)) {
            return round($this->value / (1024 * 1024), 2) . 'GB';
        } elseif ($this->value >= 1024) {
            return round($this->value / 1024, 2) . 'MB';
        } else {
            return $this->value . 'KB';
        }
    }
    public function getValue(): ?int
    {
        return $this->value;
    }
    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
    /**
     * @return Collection|MotherboardMaxRam[]
     */
    public function getMotherboardMaxRams(): Collection
    {
        return $this->motherboardMaxRams;
    }
    public function addMotherboardMaxRam(MotherboardMaxRam $motherboardMaxRam): self
    {
        if (!$this->motherboardMaxRams->contains($motherboardMaxRam)) {
            $this->motherboardMaxRams[] = $motherboardMaxRam;
            $motherboardMaxRam->setMaxram($this);
        }

        return $this;
    }
    public function removeMotherboardMaxRam(MotherboardMaxRam $motherboardMaxRam): self
    {
        if ($this->motherboardMaxRams->contains($motherboardMaxRam)) {
            $this->motherboardMaxRams->removeElement($motherboardMaxRam);
            // set the owning side to null (unless already changed)
            if ($motherboardMaxRam->getMaxram() === $this) {
                $motherboardMaxRam->setMaxram(null);
            }
        }

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
            $motherboard->setMaxVideoRam($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            // set the owning side to null (unless already changed)
            if ($motherboard->getMaxVideoRam() === $this) {
                $motherboard->setMaxVideoRam(null);
            }
        }

        return $this;
    }
}
