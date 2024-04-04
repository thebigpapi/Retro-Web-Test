<?php

namespace App\Entity;

use App\Repository\OsArchitectureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OsArchitectureRepository::class)]
class OsArchitecture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
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
