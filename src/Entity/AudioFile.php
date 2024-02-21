<?php

namespace App\Entity;

use App\Repository\AudioFileRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: AudioFileRepository::class)]
class AudioFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Audio file title is longer than {{ limit }} characters.')]
    #[Assert\NotBlank(
        message: 'Title cannot be blank'
    )]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: StorageDevice::class, inversedBy: 'audioFiles')]
    private $storageDevice;

    #[Vich\UploadableField(mapping: 'audiofile', fileNameProperty: 'file_name')]
    private File|null $audioFile = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max:255, maxMessage: 'File name is longer than {{ limit }} characters, try to make it shorter.')]
    private $file_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAudioFile(): ?File
    {
        
        return $this->audioFile;
    }

    public function setAudioFile(?File $audioFile): self
    {
        $this->audioFile = $audioFile;

        if ($this->audioFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
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
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if(null === $this->audioFile && null === $this->file_name) {
            $context->buildViolation('File is not uploaded!')
                ->atPath('audioFile')
                ->addViolation();
        }
    }
}
