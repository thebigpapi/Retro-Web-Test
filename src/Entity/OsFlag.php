<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\OsFlagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: OsFlagRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['os_flag:read', 'manufacturer:read:list']]),
        new GetCollection(normalizationContext: ['groups' => ['os_flag:read:list', 'manufacturer:read:list']]),
        new Post(denormalizationContext: ['groups' => ['os_flag:write']]),
        new Put(denormalizationContext: ['groups' => ['os_flag:write']]),
        new Delete()
    ])]
class OsFlag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['os_flag:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    #[Groups(['os_flag:read', 'os_flag:read:list', 'os_flag:write'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'File name is longer than {{ limit }} characters, try to make it shorter.')]
    #[Groups(['os_flag:read', 'os_flag:read:list', 'os_flag:write'])]
    private $file_name;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping: 'osicon', fileNameProperty: 'file_name')]
    #[Groups(['os_flag:write'])]
    private File|null $icon = null;


    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'osFlags')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['os_flag:read:list', 'os_flag:write'])]
    private $manufacturer;

    #[ORM\ManyToMany(targetEntity: LargeFile::class, mappedBy: 'osFlags')]
    private $largeFiles;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['os_flag:read'])]
    private $updated_at;

    #[ORM\Column]
    #[Groups(['os_flag:read', 'os_flag:read:list', 'os_flag:write'])]
    private ?int $sort = null;


    public function __construct()
    {
        $this->largeFiles = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getName();
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
    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }
    public function setManufacturer(?Manufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }
    /**
     * @return Collection|LargeFile[]
     */
    public function getLargeFiles(): Collection
    {
        return $this->largeFiles;
    }
    public function addLargeFile(LargeFile $largeFile): self
    {
        if (!$this->largeFiles->contains($largeFile)) {
            $this->largeFiles[] = $largeFile;
            $largeFile->addOsFlag($this);
        }

        return $this;
    }
    public function removeLargeFile(LargeFile $largeFile): self
    {
        if ($this->largeFiles->removeElement($largeFile)) {
            $largeFile->removeOsFlag($this);
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

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): static
    {
        $this->sort = $sort;

        return $this;
    }


}
