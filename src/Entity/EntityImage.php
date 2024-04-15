<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: 'App\Repository\EntityImageRepository')]
class EntityImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max:255, maxMessage: 'File name is longer than {{ limit }} characters.')]
    private $file_name;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping:'entityimage', fileNameProperty:'file_name')]
    private File|null $imageFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max:255, maxMessage: 'Description is longer than {{ limit }} characters.')]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\ManyToOne(inversedBy: 'entityImages')]
    private ?Creditor $creditor = null;

    #[ORM\ManyToOne(inversedBy: 'entityImages')]
    private ?PSUConnector $psuConnector = null;

    #[ORM\ManyToOne(inversedBy: 'entityImages')]
    private ?CpuSocket $cpuSocket = null;

    #[ORM\ManyToOne(inversedBy: 'entityImages')]
    private ?Manufacturer $manufacturer = null;

    #[ORM\ManyToOne(inversedBy: 'entityImages')]
    private ?IoPortInterface $ioPortInterface = null;

    #[ORM\ManyToOne(inversedBy: 'entityImages')]
    private ?ExpansionSlotInterface $expansionSlotInterface = null;

    #[ORM\ManyToOne(inversedBy: 'entityImages')]
    private ?IoPortInterfaceSignal $ioPortInterfaceSignal = null;

    #[ORM\ManyToOne(inversedBy: 'entityImages')]
    private ?ExpansionSlotInterfaceSignal $expansionSlotInterfaceSignal = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getFileName(): ?string
    {
        return $this->file_name;
    }
    public function setFileName(?string $file_name): self
    {
        $this->file_name = $file_name;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }
    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }

        return $this;
    }

    public function getCreditor(): ?Creditor
    {
        return $this->creditor;
    }

    public function setCreditor(?Creditor $creditor): self
    {
        $this->creditor = $creditor;

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
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if(null === $this->imageFile && null === $this->file_name) {
            $context->buildViolation('Image is not uploaded!')
                ->atPath('imageFile')
                ->addViolation();
        }
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

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

    public function getExpansionSlotInterface(): ?ExpansionSlotInterface
    {
        return $this->expansionSlotInterface;
    }

    public function setExpansionSlotInterface(?ExpansionSlotInterface $expansionSlotInterface): static
    {
        $this->expansionSlotInterface = $expansionSlotInterface;

        return $this;
    }

    public function getIoPortInterfaceSignal(): ?IoPortInterfaceSignal
    {
        return $this->ioPortInterfaceSignal;
    }

    public function setIoPortInterfaceSignal(?IoPortInterfaceSignal $ioPortInterfaceSignal): static
    {
        $this->ioPortInterfaceSignal = $ioPortInterfaceSignal;

        return $this;
    }

    public function getExpansionSlotInterfaceSignal(): ?ExpansionSlotInterfaceSignal
    {
        return $this->expansionSlotInterfaceSignal;
    }

    public function setExpansionSlotInterfaceSignal(?ExpansionSlotInterfaceSignal $expansionSlotInterfaceSignal): static
    {
        $this->expansionSlotInterfaceSignal = $expansionSlotInterfaceSignal;

        return $this;
    }
}
