<?php

namespace App\Entity;

use App\Repository\MiscFileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: MiscFileRepository::class)]
class MiscFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Vich\UploadableField(mapping: 'miscfile', fileNameProperty: 'file_name')]
    private File|null $miscFile = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Regex(
        pattern: '/^[\w\s,\/\-_#\$%&\*!\?:;\.\+\=\\\[\]\{\}\(\)]+$/',
        match: true,
        message: 'The FileName uses invalid characters',
    )]
    #[Assert\Length(max: 255, maxMessage: 'File name is longer than {{ limit }} characters, try to make it shorter.')]
    private string|null $file_name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Link bame is longer than {{ limit }} characters, try to make it shorter.')]
    private $link_name;

    #[ORM\ManyToOne(targetEntity: Motherboard::class, inversedBy: 'miscFiles')]
    private $motherboard;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLinkName(): ?string
    {
        return $this->link_name;
    }

    public function setLinkName(string $link_name): self
    {
        $this->link_name = $link_name;

        return $this;
    }

    public function getMiscFile(): ?File
    {
        return $this->miscFile;
    }

    public function setMiscFile(?File $miscFile): self
    {
        $this->miscFile = $miscFile;

        if ($this->miscFile instanceof UploadedFile) {
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
}
