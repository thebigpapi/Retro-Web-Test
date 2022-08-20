<?php

namespace App\Entity;

use App\Repository\OsFamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: OsFamilyRepository::class)]
class OsFamily
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'string', length: 255)]
    private $name;
    #[ORM\ManyToMany(targetEntity: OsFlag::class, mappedBy: 'osFamilies')]
    private $osFlags;
    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $file_name;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="osicon", fileNameProperty="file_name")
     * 
     * @var File|null
     */
    private $osIcon;
    #[ORM\Column(type: 'datetime')]
    private $updated_at;
    public function __construct()
    {
        $this->osFlags = new ArrayCollection();
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
    /**
     * @return Collection|OsFlag[]
     */
    public function getOsFlags(): Collection
    {
        return $this->osFlags;
    }
    public function addOsFlag(OsFlag $osFlag): self
    {
        if (!$this->osFlags->contains($osFlag)) {
            $this->osFlags[] = $osFlag;
            $osFlag->addOsFamily($this);
        }

        return $this;
    }
    public function removeOsFlag(OsFlag $osFlag): self
    {
        if ($this->osFlags->removeElement($osFlag)) {
            $osFlag->removeOsFamily($this);
        }

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
    public function getOsIcon(): ?File
    {
        return $this->osIcon;
    }
    public function setOsIcon(?File $osIcon): self
    {
        $this->osIcon = $osIcon;
        if ($this->osIcon instanceof UploadedFile) {
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
