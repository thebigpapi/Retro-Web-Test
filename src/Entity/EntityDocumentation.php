<?php

namespace App\Entity;

use App\Entity\Traits\DocumentationTrait;
use App\Entity\Traits\ImpreciseDateTrait;
use App\Repository\EntityDocumentationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: EntityDocumentationRepository::class)]
class EntityDocumentation
{
    use DocumentationTrait;
    use ImpreciseDateTrait;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping:'entityDoc', fileNameProperty:'file_name')]
    private File|null $manualFile = null;

    #[ORM\ManyToOne(inversedBy: 'entityDocumentations')]
    private ?ProcessorPlatformType $processorPlatformType = null;

    #[ORM\ManyToOne(inversedBy: 'entityDocumentations')]
    private ?PSUConnector $psuConnector = null;

    #[ORM\ManyToOne(inversedBy: 'entityDocumentations')]
    private ?CpuSocket $cpuSocket = null;

    #[ORM\ManyToOne(inversedBy: 'entityDocumentations')]
    private ?IoPortInterface $ioPortInterface = null;

    #[ORM\ManyToOne(inversedBy: 'entityDocumentations')]
    private ?IoPortSignal $ioPortSignal = null;

    #[ORM\ManyToOne(inversedBy: 'entityDocumentations')]
    private ?ExpansionSlotSignal $expansionSlotSignal = null;

    #[ORM\ManyToOne(inversedBy: 'entityDocumentations')]
    private ?ExpansionSlotInterface $expansionSlotInterface = null;

    public function __toString(): string
    {
        return $this->getLinkName() . " [" . $this->getReleaseDateString() . "]";
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProcessorPlatformType(): ?ProcessorPlatformType
    {
        return $this->processorPlatformType;
    }

    public function setProcessorPlatformType(?ProcessorPlatformType $processorPlatformType): self
    {
        $this->processorPlatformType = $processorPlatformType;

        return $this;
    }

    public function getPsuConnector(): ?PSUConnector
    {
        return $this->psuConnector;
    }

    public function setPsuConnector(?PSUConnector $psuConnector): self
    {
        $this->psuConnector = $psuConnector;

        return $this;
    }

    public function getCpuSocket(): ?CpuSocket
    {
        return $this->cpuSocket;
    }

    public function setCpuSocket(?CpuSocket $cpuSocket): self
    {
        $this->cpuSocket = $cpuSocket;

        return $this;
    }

    public function getIoPortInterface(): ?IoPortInterface
    {
        return $this->ioPortInterface;
    }

    public function setIoPortInterface(?IoPortInterface $ioPortInterface): static
    {
        $this->ioPortInterface = $ioPortInterface;

        return $this;
    }

    public function getIoPortSignal(): ?IoPortSignal
    {
        return $this->ioPortSignal;
    }

    public function setIoPortSignal(?IoPortSignal $ioPortSignal): static
    {
        $this->ioPortSignal = $ioPortSignal;

        return $this;
    }

    public function getExpansionSlotSignal(): ?ExpansionSlotSignal
    {
        return $this->expansionSlotSignal;
    }

    public function setExpansionSlotSignal(?ExpansionSlotSignal $expansionSlotSignal): static
    {
        $this->expansionSlotSignal = $expansionSlotSignal;

        return $this;
    }

    public function getExpansionSlotInterface(): ?ExpansionSlotInterface
    {
        return $this->expansionSlotInterface;
    }

    public function setExpansionSlotInterface(?ExpansionSlotInterface $expansionSlotInterface): static
    {
        $this->expansionSlotInterface = $expansionSlotInterface;

        return $this;
    }
}
