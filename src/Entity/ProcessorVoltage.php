<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CacheSizeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: 'App\Repository\ProcessorVoltageRepository')]
#[ApiResource(
    normalizationContext: ['groups' => 'read:ProcessorVoltage:item'],
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => ['read:ProcessorVoltage:list']]],
        'post' => ['denormalization_context' => ['groups' => 'write:ProcessorVoltage']]
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:ProcessorVoltage:item']],
        'put' => ['denormalization_context' => ['groups' => 'write:ProcessorVoltage']],
        'delete'
    ],
    order: ['name' => 'ASC'],
    paginationEnabled: true,
)]
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
