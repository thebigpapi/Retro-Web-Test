<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MaxRamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MaxRamRepository::class)]
#[UniqueEntity('value')]
#[ApiResource(
    normalizationContext: ['groups' => 'read:MaxRam:item'],
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:MaxRam:list']], 
        'post' => ['denormalization_context' => ['groups' => 'write:MaxRam']]
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:MaxRam:item']],
        'put' => ['denormalization_context' => ['groups' => 'write:MaxRam']],
        'delete'
    ],
    order: ['value' => 'ASC'],
    paginationEnabled: false,
)]
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
