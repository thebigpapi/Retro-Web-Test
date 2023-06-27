<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\LanguageRepository;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'read:Language:item']),
        new Put(denormalizationContext: ['groups' => 'write:Language']),
        new Delete(),
        new GetCollection(normalizationContext: ['groups' => 'read:Language:list']),
        new Post(denormalizationContext: ['groups' => 'write:Language'])
    ],
    normalizationContext: ['groups' => 'read:Language:item'],
    order: ['name' => 'ASC'],
    paginationEnabled: false
)]
#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Language:list', 'read:Language:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Language:list', 'read:Language:item', 'write:Language'])]
    private $name;

    #[ORM\OneToMany(targetEntity: Manual::class, mappedBy: 'language')]
    private $manuals;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:Language:list', 'read:Language:item', 'write:Language'])]
    private $originalName;

    #[ORM\Column(type: 'string', length: 10)]
    #[Groups(['read:Language:list', 'read:Language:item', 'write:Language'])]
    private $isoCode;

    #[ORM\ManyToMany(targetEntity: LargeFile::class, mappedBy: 'languages')]
    private $largeFiles;

    public function __construct()
    {
        $this->manuals = new ArrayCollection();
        $this->largeFiles = new ArrayCollection();
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
     * @return Collection|Manual[]
     */
    public function getManuals(): Collection
    {
        return $this->manuals;
    }
    public function addManual(Manual $manual): self
    {
        if (!$this->manuals->contains($manual)) {
            $this->manuals[] = $manual;
            $manual->setLanguage($this);
        }

        return $this;
    }
    public function removeManual(Manual $manual): self
    {
        if ($this->manuals->contains($manual)) {
            $this->manuals->removeElement($manual);
            // set the owning side to null (unless already changed)
            if ($manual->getLanguage() === $this) {
                $manual->setLanguage(null);
            }
        }

        return $this;
    }
    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }
    public function setOriginalName(string $originalName): self
    {
        $this->originalName = $originalName;

        return $this;
    }
    public function getIsoCode(): ?string
    {
        return $this->isoCode;
    }
    public function setIsoCode(string $isoCode): self
    {
        $this->isoCode = $isoCode;

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
            $largeFile->addLanguage($this);
        }

        return $this;
    }
    public function removeLargeFile(LargeFile $largeFile): self
    {
        if ($this->largeFiles->removeElement($largeFile)) {
            $largeFile->removeLanguage($this);
        }

        return $this;
    }
}
