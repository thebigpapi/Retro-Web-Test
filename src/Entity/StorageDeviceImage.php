<?php

namespace App\Entity;

use App\Repository\StorageDeviceImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: StorageDeviceImageRepository::class)]
class StorageDeviceImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: StorageDevice::class, inversedBy: 'storageDeviceImages')]
    #[ORM\JoinColumn(nullable: false)]
    private $storageDevice;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max:255, maxMessage: 'File name is longer than {{ limit }} characters, try to make it shorter.')]
    private $file_name;

    #[Vich\UploadableField(mapping:'storageimage', fileNameProperty:'file_name')]
    private File|null $imageFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max:255, maxMessage: 'Description is longer than {{ limit }} characters, try to make it shorter.')]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\ManyToOne(targetEntity: Creditor::class, inversedBy: 'storageDeviceImages')]
    private $creditor;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStorageDevice(): ?StorageDevice
    {
        return $this->storageDevice;
    }

    public function setStorageDevice(?StorageDevice $storageDevice): self
    {
        $this->storageDevice = $storageDevice;

        return $this;
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

    public function getCreditor(): ?Creditor
    {
        return $this->creditor;
    }

    public function setCreditor(?Creditor $creditor): self
    {
        $this->creditor = $creditor;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getTypeFormatted(): string
    {
        switch($this->type){
            case 1: return "Schema";
            case 2: return "Top photo";
            case 3: return "Front photo";
            case 4: return "Back photo";
            case 5: return "Bottom photo";
            case 6: return "Misc";
            default: return "";
        }
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
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if(null === $this->imageFile && null === $this->file_name) {
            $context->buildViolation('Image is not uploaded!')
                ->atPath('imageFile')
                ->addViolation();
        }
    }
}
