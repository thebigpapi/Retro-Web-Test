<?php

namespace App\Entity;

use App\Repository\LargeFileChipsetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LargeFileChipsetRepository::class)]
class LargeFileChipset
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\ManyToOne(targetEntity: LargeFile::class, inversedBy: 'chipsets')]
    #[ORM\JoinColumn(nullable: false)]
    private $largeFile;
    #[ORM\ManyToOne(targetEntity: Chipset::class, inversedBy: 'drivers')]
    #[ORM\JoinColumn(nullable: false)]
    private $chipset;
    #[ORM\Column(type: 'boolean')]
    private $isRecommended;
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getLargeFile(): ?LargeFile
    {
        return $this->largeFile;
    }
    public function setLargeFile(?LargeFile $largeFile): self
    {
        $this->largeFile = $largeFile;

        return $this;
    }
    public function getChipset(): ?Chipset
    {
        return $this->chipset;
    }
    public function setChipset(?Chipset $chipset): self
    {
        $this->chipset = $chipset;

        return $this;
    }
    public function getIsRecommended(): ?bool
    {
        return $this->isRecommended;
    }
    public function setIsRecommended(bool $isRecommended): self
    {
        $this->isRecommended = $isRecommended;

        return $this;
    }
}
