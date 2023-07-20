<?php

namespace App\Entity;

use App\Repository\DumpQualityFlagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DumpQualityFlagRepository::class)]
class DumpQualityFlag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Tag name is longer than {{ limit }} characters, try to make it shorter.')]
    private $tagName;

    #[ORM\OneToMany(targetEntity: LargeFile::class, mappedBy: 'dumpQualityFlag')]
    private $largeFiles;

    public function __construct()
    {
        $this->largeFiles = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->name;
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
    public function getTagName(): ?string
    {
        return $this->tagName;
    }
    public function setTagName(string $tagName): self
    {
        $this->tagName = $tagName;

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
            $largeFile->setDumpQualityFlag($this);
        }

        return $this;
    }
    public function removeLargeFile(LargeFile $largeFile): self
    {
        if ($this->largeFiles->removeElement($largeFile)) {
            // set the owning side to null (unless already changed)
            if ($largeFile->getDumpQualityFlag() === $this) {
                $largeFile->setDumpQualityFlag(null);
            }
        }

        return $this;
    }
}
