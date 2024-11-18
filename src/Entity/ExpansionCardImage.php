<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use App\Repository\ExpansionCardImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ExpansionCardImageRepository::class)]
class ExpansionCardImage
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
    #[Vich\UploadableField(mapping:'cardimage', fileNameProperty:'file_name')]
    private File|null $imageFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max:255, maxMessage: 'Description is longer than {{ limit }} characters.')]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\ManyToOne(targetEntity: Creditor::class, inversedBy: 'cardImages')]
    private $creditor;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?ExpansionCard $expansionCard = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Image type cannot be blank'
    )]
    private ?string $type = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotBlank(message: 'Sort position cannot be blank')]
    #[Assert\Positive(message: "Sort position should be above 0")]
    private ?int $sort = null;

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
    public function getCreditor(): ?Creditor
    {
        return $this->creditor;
    }
    public function setCreditor(?Creditor $creditor): self
    {
        $this->creditor = $creditor;

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

    public function getExpansionCard(): ?ExpansionCard
    {
        return $this->expansionCard;
    }

    public function setExpansionCard(?ExpansionCard $expansionCard): static
    {
        $this->expansionCard = $expansionCard;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTypeFormatted(): string
    {
        switch($this->type){
            case 1: return "Schema";
            case 2: return "Photo front";
            case 3: return "Photo back";
            case 4: return "Photo misc";
            case 5: return "Schema misc";
            case 6: return "Photo bracket";
            default: return "";
        }
    }
    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): static
    {
        $this->sort = $sort;

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
