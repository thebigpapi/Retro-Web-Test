<?php

namespace App\Entity;

use App\Repository\ExpansionCardBiosRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ExpansionCardBiosRepository::class)]
class ExpansionCardBios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $version = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardBios')]
    private ?ExpansionCard $expansionCard = null;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping: 'bios', fileNameProperty: 'file_name')]
    private File|null $romFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'BIOS file name is longer than {{ limit }} characters, try to make it shorter.')]
    private string|null $file_name = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'BIOS note is longer than {{ limit }} characters, try to make it shorter.')]
    private $note;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hash = null;
    public function __construct()
    {
        $this->updated_at = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): static
    {
        $this->version = $version;

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
    public function getFileName(): ?string
    {
        return $this->file_name;
    }
    public function setFileName(?string $file_name): self
    {
        $this->file_name = $file_name;

        return $this;
    }
    public function getRomFile(): ?File
    {
        return $this->romFile;
    }
    public function setRomFile(?File $romFile): self
    {
        $this->romFile = $romFile;
        if ($this->romFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }

        return $this;
    }
    public function getNote(): ?string
    {
        return $this->note;
    }
    public function setNote(?string $note): self
    {
        $this->note = $note;

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
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if(!isset($this->romFile) && !isset($this->file_name)) {
            $context->buildViolation('File is not uploaded!')
                ->atPath('romFile')
                ->addViolation();
        }
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(?string $hash): static
    {
        $this->hash = $hash;

        return $this;
    }
    public function updateHash()
    {
        if($this->romFile){
            $this->setHash(hash_file('sha256', $this->romFile->getPathname()));
        }
    }
}
