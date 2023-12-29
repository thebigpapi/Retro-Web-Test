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
}
