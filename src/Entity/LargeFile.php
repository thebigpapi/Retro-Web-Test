<?php

namespace App\Entity;

use App\Entity\Traits\ImpreciseDateTrait;
use App\Repository\LargeFileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: LargeFileRepository::class)]
class LargeFile
{
    use ImpreciseDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Regex(
        pattern: '/^[\w\s,\/\-_#\$%&\*!\?:;\.\+\=\\\[\]\{\}\(\)]+$/',
        match: true,
        message: 'The name uses invalid characters',
    )]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;
    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'File name is longer than {{ limit }} characters, try to make it shorter.')]
    private $file_name;

    #[Vich\UploadableField(mapping: 'largefile', fileNameProperty: 'file_name', size: 'size')]
    private File|null $file = null;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\ManyToOne(targetEntity: DumpQualityFlag::class, inversedBy: 'largeFiles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message: 'Flag cannot be blank'
    )]
    private $dumpQualityFlag;

    #[ORM\ManyToMany(targetEntity: Language::class, inversedBy: 'largeFiles')]
    private $languages;

    #[ORM\Column(type: 'string', length: 255)]
    private $subdirectory;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Version is longer than {{ limit }} characters, try to make it shorter.')]
    private $fileVersion;

    #[ORM\OneToMany(targetEntity: LargeFileMediaTypeFlag::class, mappedBy: 'largeFile', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $mediaTypeFlags;

    #[ORM\ManyToMany(targetEntity: OsFlag::class, inversedBy: 'largeFiles')]
    private $osFlags;

    #[ORM\OneToMany(targetEntity: LargeFileMotherboard::class, mappedBy: 'largeFile', orphanRemoval: true)]
    private $motherboards;

    #[ORM\OneToMany(targetEntity: LargeFileChipset::class, mappedBy: 'largeFile', orphanRemoval: true)]
    private $chipsets;

    #[ORM\Column(type: 'string', length: 4096, nullable: true)]
    #[Assert\Length(max: 4096, maxMessage: 'Note is longer than {{ limit }} characters, try to make it shorter.')]
    private $note;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $size;

    #[ORM\OneToMany(targetEntity: LargeFileExpansionChip::class, mappedBy: 'largeFile', orphanRemoval: true, cascade: ['persist'])]
    private $expansionchips;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lastEdited = null;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->mediaTypeFlags = new ArrayCollection();
        $this->osFlags = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
        $this->chipsets = new ArrayCollection();
        $this->expansionchips = new ArrayCollection();
        $this->lastEdited = new \DateTime('now');
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
            $osFlag->addLargeFile($this);
        }

        return $this;
    }
    public function removeOsFlag(OsFlag $osFlag): self
    {
        if ($this->osFlags->removeElement($osFlag)) {
            $osFlag->removeLargeFile($this);
        }

        return $this;
    }
    public function getNameWithTags(): string
    {
        $tmp = $this->getLanguages();
        $langs = "";
        foreach ($tmp as $key => $language) {
            if (array_key_last($tmp->toArray()) == $key) {
                $langs .= $language->getIsoCode();
            } else {
                $langs .= $language->getIsoCode() . ", ";
            }
        }

        $tmp = $this->getOsFlags();
        $osTags = "";
        foreach ($tmp as $key => $os) {
            if (array_key_last($tmp->toArray()) == $key) {
                $osTags .=  $os->getVersion();
            } else {
                $osTags .=  $os->getVersion() . ", ";
            }
        }

        $tmp = $this->getMediaTypeFlags();
        $mediaTypeTags = "";
        foreach ($tmp as $key => $media) {
            if (array_key_last($tmp->toArray()) == $key) {
                $mediaTypeTags .=  $media->getMediaTypeFlag()->getTagName();
            } else {
                $mediaTypeTags .=  $media->getMediaTypeFlag()->getTagName() . ", ";
            }
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
    public function getNote(): ?string
    {
        return $this->note;
    }
    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
    public function getSize(): ?int
    {
        return $this->size;
    }
    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }
    /**
     * @return Collection|LargeFileExpansionChip[]
     */
    public function getExpansionChips(): ?Collection
    {
        return $this->expansionchips;
    }
    public function addExpansionChip(LargeFileExpansionChip $expansionChip): self
    {
        if (!$this->expansionchips->contains($expansionChip)) {
            $this->expansionchips[] = $expansionChip;
            $expansionChip->setLargeFile($this);
        }

        return $this;
    }
    public function removeExpansionChip(LargeFileExpansionChip $expansionChip): self
    {
        if ($this->expansionchips->removeElement($expansionChip)) {
            // set the owning side to null (unless already changed)
            if ($expansionChip->getLargeFile() === $this) {
                $expansionChip->setLargeFile(null);
            }
        }

        return $this;
    }

    public function getLastEdited(): ?\DateTimeInterface
    {
        return $this->lastEdited;
    }

    public function setLastEdited(\DateTimeInterface $lastEdited): self
    {
        $this->lastEdited = $lastEdited;
        return $this;
    }

    public function updateLastEdited()
    {
        $this->lastEdited = new \DateTime('now');
    }

    public function getMetaDescription(): string
    {
        $strBuilder = "Download ";
        if ($this->getName()) {
            $strBuilder .= $this->getName();
        }

        $fileVer = $this->getFileVersion();
        if (is_string($fileVer) && strlen($fileVer)) {
            $strBuilder .= ", version " . $fileVer;
        }

        $relDate = $this->getReleaseDateString();
        if (is_string($relDate) && strlen($relDate)) {
            $strBuilder .= ", released " . $relDate;
        }

        return $strBuilder;
    }
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if(null === $this->file && null === $this->file_name) {
            $context->buildViolation('File is not uploaded!')
                ->atPath('file')
                ->addViolation();
        }
    }
}
