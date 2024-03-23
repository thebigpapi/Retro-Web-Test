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
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Version is longer than {{ limit }} characters.')]
    private $version;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'osFlags')]
    #[ORM\JoinColumn(nullable: true)]
    private $manufacturer;

    #[ORM\ManyToMany(targetEntity: LargeFile::class, mappedBy: 'osFlags')]
    private $largeFiles;

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
    public function getVersion(): ?string
    {
        return $this->version;
    }
    public function setVersion(string $version): self
    {
        $this->version = $version;

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
}
