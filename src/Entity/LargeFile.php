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

    /**
     * @ORM\OneToMany(targetEntity=LargeFileMotherboard::class, mappedBy="largeFile", orphanRemoval=true)
     */
    private $motherboards;

    /**
     * @ORM\OneToMany(targetEntity=LargeFileChipset::class, mappedBy="largeFile", orphanRemoval=true)
     */
    private $chipsets;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->mediaTypeFlags = new ArrayCollection();
        $this->osFlags = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
        $this->chipsets = new ArrayCollection();
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

    public function getNameWithTags(): string
    {
        $tmp = $this->getLanguages();
        $langs = "";
        foreach ($tmp as $key => $language) {
            if(array_key_last($tmp->toArray())==$key)
                $langs .= $language->getIsoCode();
            else
                $langs .= $language->getIsoCode() . ", ";
        }

        $tmp = $this->getOsFlags();
        $osTags = "";
        foreach ($tmp as $key => $os) {
            if(array_key_last($tmp->toArray())==$key)
                $osTags .=  $os->getOsFlag()->getFullVersion();
            else
                $osTags .=  $os->getOsFlag()->getFullVersion() . ", ";
        }

        $tmp = $this->getMediaTypeFlags();
        $mediaTypeTags = "";
        foreach ($tmp as $key => $media) {
            if(array_key_last($tmp->toArray())==$key)
                $mediaTypeTags .=  $media->getMediaTypeFlag()->getTagName();
            else
                $mediaTypeTags .=  $media->getMediaTypeFlag()->getTagName() . ", ";
        }

        return $this->getName() . " " . $this->getFileVersion() ?? "" . " [" . $langs . "] [" . $mediaTypeTags . "] [" . $osTags . "]";
    }

    /**
     * @return Collection|LargeFileMotherboard[]
     */
    public function getMotherboards(): Collection
    {
        return $this->motherboards;
    }

    public function addMotherboard(LargeFileMotherboard $motherboard): self
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->setLargeFile($this);
        }

        return $this;
    }

    public function removeMotherboard(LargeFileMotherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            // set the owning side to null (unless already changed)
            if ($motherboard->getLargeFile() === $this) {
                $motherboard->setLargeFile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LargeFileChipset[]
     */
    public function getChipsets(): Collection
    {
        return $this->chipsets;
    }

    public function addChipset(LargeFileChipset $chipset): self
    {
        if (!$this->chipsets->contains($chipset)) {
            $this->chipsets[] = $chipset;
            $chipset->setLargeFile($this);
        }

        return $this;
    }

    public function removeChipset(LargeFileChipset $chipset): self
    {
        if ($this->chipsets->removeElement($chipset)) {
            // set the owning side to null (unless already changed)
            if ($chipset->getLargeFile() === $this) {
                $chipset->setLargeFile(null);
            }
        }

        return $this;
    }
}
