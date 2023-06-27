<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CacheSizeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'read:CpuSpeed:item']),
        new Put(denormalizationContext: ['groups' => 'write:CpuSpeed']),
        new Delete(),
        new GetCollection(normalizationContext: ['groups' => ['read:CpuSpeed:list']]),
        new Post(denormalizationContext: ['groups' => 'write:CpuSpeed'])
    ],
    normalizationContext: ['groups' => 'read:CpuSpeed:item'],
    order: ['name' => 'ASC'],
    paginationEnabled: true
)]
#[ORM\Entity(repositoryClass: CacheSizeRepository::class)]
class CpuSpeed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:CpuSpeed:list', 'read:CpuSpeed:item'])]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Assert\PositiveOrZero]
    #[Groups(['read:CpuSpeed:list', 'read:CpuSpeed:item', 'write:CpuSpeed'])]
    private $value;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'cpuSpeed')]
    private $motherboards;

    #[ORM\OneToMany(targetEntity: ProcessingUnit::class, mappedBy: 'speed')]
    private $processingUnits;

    #[ORM\OneToMany(targetEntity: ProcessingUnit::class, mappedBy: 'fsb')]
    private $processingUnitsFsb;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->processingUnits = new ArrayCollection();
        $this->processingUnitsFsb = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getValueWithUnit(): ?string
    {
        return $this->value . 'MHz';
    }
    public function getValue(): ?float
    {
        return $this->value;
    }
    public function setValue(float $value): self
    {
        $this->value = $value;

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
            $motherboard->addCpuSpeed($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            $motherboard->removeCpuSpeed($this);
        }

        return $this;
    }
    /**
     * @return Collection|ProcessingUnit[]
     */
    public function getProcessingUnits(): Collection
    {
        return $this->processingUnits;
    }
    public function addProcessingUnit(ProcessingUnit $processingUnit): self
    {
        if (!$this->processingUnits->contains($processingUnit)) {
            $this->processingUnits[] = $processingUnit;
            $processingUnit->setSpeed($this);
        }

        return $this;
    }
    public function removeProcessingUnit(ProcessingUnit $processingUnit): self
    {
        if ($this->processingUnits->contains($processingUnit)) {
            $this->processingUnits->removeElement($processingUnit);
            // set the owning side to null (unless already changed)
            if ($processingUnit->getSpeed() === $this) {
                $processingUnit->setSpeed(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|ProcessingUnit[]
     */
    public function getProcessingUnitsFsb(): Collection
    {
        return $this->processingUnitsFsb;
    }
    public function addProcessingUnitsFsb(ProcessingUnit $processingUnitsFsb): self
    {
        if (!$this->processingUnitsFsb->contains($processingUnitsFsb)) {
            $this->processingUnitsFsb[] = $processingUnitsFsb;
            $processingUnitsFsb->setFsb($this);
        }

        return $this;
    }
    public function removeProcessingUnitsFsb(ProcessingUnit $processingUnitsFsb): self
    {
        if ($this->processingUnitsFsb->contains($processingUnitsFsb)) {
            $this->processingUnitsFsb->removeElement($processingUnitsFsb);
            // set the owning side to null (unless already changed)
            if ($processingUnitsFsb->getFsb() === $this) {
                $processingUnitsFsb->setFsb(null);
            }
        }

        return $this;
    }
}
