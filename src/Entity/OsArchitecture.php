<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\OsArchitectureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OsArchitectureRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['os_architecture:read']]),
        new GetCollection(normalizationContext: ['groups' => ['os_architecture:read:list']]),
        new Post(denormalizationContext: ['groups' => ['os_architecture:write']]),
        new Put(denormalizationContext: ['groups' => ['os_architecture:write']]),
        new Delete()
    ])]
class OsArchitecture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['os_architecture:read', 'os_architecture:read:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['os_architecture:read', 'os_architecture:read:list', 'os_architecture:write'])]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: LargeFile::class, mappedBy: 'osArchitecture')]
    private Collection $largeFiles;

    public function __construct()
    {
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

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, LargeFile>
     */
    public function getLargeFiles(): Collection
    {
        return $this->largeFiles;
    }

    public function addLargeFile(LargeFile $largeFile): static
    {
        if (!$this->largeFiles->contains($largeFile)) {
            $this->largeFiles->add($largeFile);
            $largeFile->addOsArchitecture($this);
        }

        return $this;
    }

    public function removeLargeFile(LargeFile $largeFile): static
    {
        if ($this->largeFiles->removeElement($largeFile)) {
            $largeFile->removeOsArchitecture($this);
        }

        return $this;
    }
}
