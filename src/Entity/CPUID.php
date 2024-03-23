<?php

namespace App\Entity;

use App\Repository\CPUIDRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CPUIDRepository::class)]
class CPUID
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'cpuid')]
    private ?ProcessorPlatformType $processorPlatformType = null;

    public function __toString() : string
    {
        return $this->value;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getProcessorPlatformType(): ?ProcessorPlatformType
    {
        return $this->processorPlatformType;
    }

    public function setProcessorPlatformType(?ProcessorPlatformType $processorPlatformType): static
    {
        $this->processorPlatformType = $processorPlatformType;

        return $this;
    }
}
