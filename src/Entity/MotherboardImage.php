<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: 'App\Repository\MotherboardImageRepository')]
class MotherboardImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\MotherboardImageType', inversedBy: 'motherboardImages')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboardImageType;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Motherboard', inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;

    #[ORM\Column(type: 'string', length: 255)]
    private string|null $file_name;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping:'image', fileNameProperty:'file_name')]
    private File|null $imageFile;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string|null $description;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Creditor', inversedBy: 'motherboardImages')]
    private $creditor;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\License', inversedBy: 'motherboardImages')]
    #[ORM\JoinColumn(nullable: false)]
    private $license;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getMotherboardImageType(): ?MotherboardImageType
    {
        return $this->motherboardImageType;
    }
    public function setMotherboardImageType(?MotherboardImageType $motherboardImageType): self
    {
        $this->motherboardImageType = $motherboardImageType;

        return $this;
    }
    public function getMotherboard(): ?Motherboard
    {
        return $this->motherboard;
    }
    public function setMotherboard(?Motherboard $motherboard): self
    {
        $this->motherboard = $motherboard;

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
    public function getLicense(): ?License
    {
        return $this->license;
    }
    public function setLicense(?License $license): self
    {
        $this->license = $license;

        return $this;
    }
}
