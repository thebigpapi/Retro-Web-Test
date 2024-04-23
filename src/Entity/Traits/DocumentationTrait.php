<?php

namespace App\Entity\Traits;

use App\Repository\ManualRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ManualRepository::class)]
trait DocumentationTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max:255, maxMessage: 'File name is longer than {{ limit }} characters.')]
    #[Assert\Regex(
        pattern: '/^[\w\s,\/\-_#\$%&\*!\?:;\.\+\=\\\[\]\{\}\(\)]+$/',
        match: true,
        message: 'The name uses invalid characters',
    )]
    private $file_name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max:255, maxMessage: 'Documentation title is longer than {{ limit }} characters.')]
    #[Assert\NotBlank(
        message: 'Documentation title cannot be blank'
    )]
    private $link_name;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;


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

    public function getLinkName(): ?string
    {
        return $this->link_name;
    }

    public function setLinkName(string $link_name): self
    {
        $this->link_name = $link_name;

        return $this;
    }

    public function getManualFile(): ?File
    {
        return $this->manualFile;
    }
    public function setManualFile(?File $manualFile): self
    {
        $this->manualFile = $manualFile;
        if ($this->manualFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }

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
        if(null === $this->manualFile && null === $this->file_name) {
            $context->buildViolation('File is not uploaded!')
                ->atPath('manualFile')
                ->addViolation();
        }
    }
}
