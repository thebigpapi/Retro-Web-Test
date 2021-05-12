<?php

namespace App\Entity;

use App\Repository\LargeFileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=LargeFileRepository::class)
 * @Vich\Uploadable
 */
class LargeFile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $file_name;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="largefile", fileNameProperty="file_name")
     * 
     * @var File|null
     */
    private $file;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=DumpQualityFlag::class, inversedBy="largeFiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dumpQualityFlag;

    /**
     * @ORM\ManyToMany(targetEntity=Language::class, inversedBy="largeFiles")
     */
    private $languages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subdirectory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fileVersion;

    /**
     * @ORM\OneToMany(targetEntity=LargeFileMediaTypeFlag::class, mappedBy="largeFile", orphanRemoval=true, cascade={"persist"})
     */
    private $mediaTypeFlags;

    /**
     * @ORM\OneToMany(targetEntity=LargeFileOsFlag::class, mappedBy="largeFile", orphanRemoval=true, cascade={"persist"})
     */
    private $osFlags;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasActivationKey;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasCopyProtection;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->mediaTypeFlags = new ArrayCollection();
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

    public function getFileName(): ?string
    {
        return $this->file_name;
    }

    public function setFileName(?string $file_name): self
    {
        $this->file_name = $file_name;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }
    public function setFile(?File $file): self
    {
        $this->file = $file;
        if ($this->file instanceof UploadedFile) {
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

    public function getDumpQualityFlag(): ?DumpQualityFlag
    {
        return $this->dumpQualityFlag;
    }

    public function setDumpQualityFlag(?DumpQualityFlag $dumpQualityFlag): self
    {
        $this->dumpQualityFlag = $dumpQualityFlag;

        return $this;
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        $this->languages->removeElement($language);

        return $this;
    }

    public function getSubdirectory(): ?string
    {
        return $this->subdirectory;
    }

    public function setSubdirectory(string $subdirectory): self
    {
        $this->subdirectory = $subdirectory;

        return $this;
    }

    public function getFileVersion(): ?string
    {
        return $this->fileVersion;
    }

    public function setFileVersion(?string $fileVersion): self
    {
        $this->fileVersion = $fileVersion;

        return $this;
    }

    /**
     * @return Collection|LargeFileMediaTypeFlag[]
     */
    public function getMediaTypeFlags(): Collection
    {
        return $this->mediaTypeFlags;
    }

    public function addMediaTypeFlag(LargeFileMediaTypeFlag $mediaTypeFlag): self
    {
        if (!$this->mediaTypeFlags->contains($mediaTypeFlag)) {
            $this->mediaTypeFlags[] = $mediaTypeFlag;
            $mediaTypeFlag->setLargeFile($this);
        }

        return $this;
    }

    public function removeMediaTypeFlag(LargeFileMediaTypeFlag $mediaTypeFlag): self
    {
        if ($this->mediaTypeFlags->removeElement($mediaTypeFlag)) {
            // set the owning side to null (unless already changed)
            if ($mediaTypeFlag->getLargeFile() === $this) {
                $mediaTypeFlag->setLargeFile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LargeFileOsFlag[]
     */
    public function getOsFlags(): Collection
    {
        return $this->osFlags;
    }

    public function addOsFlag(LargeFileOsFlag $osFlag): self
    {
        if (!$this->osFlags->contains($osFlag)) {
            $this->osFlags[] = $osFlag;
            $osFlag->setLargeFile($this);
        }

        return $this;
    }

    public function removeOsFlag(LargeFileOsFlag $osFlag): self
    {
        if ($this->osFlags->removeElement($osFlag)) {
            // set the owning side to null (unless already changed)
            if ($osFlag->getLargeFile() === $this) {
                $osFlag->setLargeFile(null);
            }
        }

        return $this;
    }

    public function getHasActivationKey(): ?bool
    {
        return $this->hasActivationKey;
    }

    public function setHasActivationKey(bool $hasActivationKey): self
    {
        $this->hasActivationKey = $hasActivationKey;

        return $this;
    }

    public function getHasCopyProtection(): ?bool
    {
        return $this->hasCopyProtection;
    }

    public function setHasCopyProtection(bool $hasCopyProtection): self
    {
        $this->hasCopyProtection = $hasCopyProtection;

        return $this;
    }
}
