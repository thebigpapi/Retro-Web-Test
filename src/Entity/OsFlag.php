<?php

namespace App\Entity;

use App\Repository\OsFlagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OsFlagRepository::class)]
class OsFlag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Major version is longer than {{ limit }} characters, try to make it shorter.')]
    private $majorVersion;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Minor version is longer than {{ limit }} characters, try to make it shorter.')]
    private $minorVersion;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'osFlags')]
    #[ORM\JoinColumn(nullable: true)]
    private $manufacturer;

    #[ORM\OneToMany(targetEntity: LargeFileOsFlag::class, mappedBy: 'osFlag', orphanRemoval: true)]
    private $largeFiles;

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
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getMajorVersion(): ?string
    {
        return $this->majorVersion;
    }
    public function setMajorVersion(string $majorVersion): self
    {
        $this->majorVersion = $majorVersion;

        return $this;
    }
    public function getMinorVersion(): ?string
    {
        return $this->minorVersion;
    }
    public function setMinorVersion(?string $minorVersion): self
    {
        $this->minorVersion = $minorVersion;

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
     * @return Collection|LargeFileOsFlag[]
     */
    public function getLargeFiles(): Collection
    {
        return $this->largeFiles;
    }
    public function addLargeFile(LargeFileOsFlag $largeFile): self
    {
        if (!$this->largeFiles->contains($largeFile)) {
            $this->largeFiles[] = $largeFile;
            $largeFile->setOsFlag($this);
        }

        return $this;
    }
    public function removeLargeFile(LargeFileOsFlag $largeFile): self
    {
        if ($this->largeFiles->removeElement($largeFile)) {
            // set the owning side to null (unless already changed)
            if ($largeFile->getOsFlag() === $this) {
                $largeFile->setOsFlag(null);
            }
        }

        return $this;
    }
    public function getFullVersion(): string
    {
        return $this->minorVersion ? "$this->majorVersion.$this->minorVersion" : "$this->majorVersion";
    }
}
