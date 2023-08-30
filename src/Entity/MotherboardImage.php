<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: 'App\Repository\MotherboardImageRepository')]
class MotherboardImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: MotherboardImageType::class, inversedBy: 'motherboardImages')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboardImageType;

    #[ORM\ManyToOne(targetEntity: Motherboard::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Image file name is longer than {{ limit }} characters, try to make it shorter.')]
    private $file_name;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping: 'image', fileNameProperty: 'file_name')]
    private File|null $imageFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Image description is longer than {{ limit }} characters, try to make it shorter.')]
    private string|null $description;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\ManyToOne(targetEntity: Creditor::class, inversedBy: 'motherboardImages')]
    private $creditor;

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
