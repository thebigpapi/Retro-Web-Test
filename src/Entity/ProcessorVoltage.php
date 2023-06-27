<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ProcessorVoltageRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'read:ProcessorVoltage:item']),
        new Put(denormalizationContext: ['groups' => 'write:ProcessorVoltage']),
        new Delete(),
        new GetCollection(normalizationContext: ['groups' => ['read:ProcessorVoltage:list']]),
        new Post(denormalizationContext: ['groups' => 'write:ProcessorVoltage'])
    ],
    normalizationContext: ['groups' => 'read:ProcessorVoltage:item'],
    order: ['name' => 'ASC'],
    paginationEnabled: true
)]
#[ORM\Entity(repositoryClass: ProcessorVoltageRepository::class)]
class ProcessorVoltage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:ProcessorVoltage:list', 'read:ProcessorVoltage:item'])]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(['read:ProcessorVoltage:list', 'read:ProcessorVoltage:item', 'write:ProcessorVoltage'])]
    private $value;

    #[ORM\ManyToOne(targetEntity: Processor::class, inversedBy: 'voltages')]
    #[ORM\JoinColumn(nullable: false)]
    private $processor;

    public function getId(): ?int
    {
        return $this->id;
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
    public function getValueWithUnit(): ?string
    {
        return $this->value . "V";
    }
    public function getProcessor(): ?Processor
    {
        return $this->processor;
    }
    public function setProcessor(?Processor $processor): self
    {
        $this->processor = $processor;

        return $this;
    }
}
