<?php

namespace App\Entity;

use App\Repository\MediaTypeFlagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: MediaTypeFlagRepository::class)]
class MediaTypeFlag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Tag name is longer than {{ limit }} characters, try to make it shorter.')]
    private $tagName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'File name is longer than {{ limit }} characters, try to make it shorter.')]
    private $file_name;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping: 'mediatypeicon', fileNameProperty: 'file_name')]
    private File|null $icon = null;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\OneToMany(targetEntity: LargeFileMediaTypeFlag::class, mappedBy: 'mediaTypeFlag', orphanRemoval: true)]
    private $getLargeFiles;

    public function __construct()
    {
        $this->getLargeFiles = new ArrayCollection();
    }
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
    public function getTagName(): ?string
    {
        return $this->tagName;
    }
    public function setTagName(string $tagName): self
    {
        $this->tagName = $tagName;

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
    public function getIcon(): ?File
    {
        return $this->icon;
    }
    public function setIcon(?File $icon): self
    {
        $this->icon = $icon;
        if ($this->icon instanceof UploadedFile) {
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
    /**
     * @return Collection|LargeFileMediaTypeFlag[]
     */
    public function getGetLargeFiles(): Collection
    {
        return $this->getLargeFiles;
    }
    public function addGetLargeFile(LargeFileMediaTypeFlag $getLargeFile): self
    {
        if (!$this->getLargeFiles->contains($getLargeFile)) {
            $this->getLargeFiles[] = $getLargeFile;
            $getLargeFile->setMediaTypeFlag($this);
        }

        return $this;
    }
    public function removeGetLargeFile(LargeFileMediaTypeFlag $getLargeFile): self
    {
        if ($this->getLargeFiles->removeElement($getLargeFile)) {
            // set the owning side to null (unless already changed)
            if ($getLargeFile->getMediaTypeFlag() === $this) {
                $getLargeFile->setMediaTypeFlag(null);
            }
        }

        return $this;
    }
}
