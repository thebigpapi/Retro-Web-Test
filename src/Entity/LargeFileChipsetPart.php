<?php

namespace App\Entity;

use App\Repository\LargeFileChipsetPartRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LargeFileChipsetPartRepository::class)]
class LargeFileChipsetPart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(inversedBy: 'chipsetparts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?LargeFile $largeFile = null;

    #[ORM\ManyToOne(inversedBy: 'drivers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ChipsetPart $chipsetPart = null;

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

    public function getChipsetPart(): ?ChipsetPart
    {
        return $this->chipsetPart;
    }

    public function setChipsetPart(?ChipsetPart $chipsetPart): self
    {
        $this->chipsetPart = $chipsetPart;

        return $this;
    }

    public function isIsRecommended(): ?bool
    {
        return $this->isRecommended;
    }

    public function setIsRecommended(bool $isRecommended): self
    {
        $this->isRecommended = $isRecommended;

        return $this;
    }
}
