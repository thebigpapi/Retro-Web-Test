<?php

namespace App\Entity;

use App\Repository\LargeFileExpansionChipRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LargeFileExpansionChipRepository::class)]
class LargeFileExpansionChip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: LargeFile::class, inversedBy: 'expansionchips')]
    #[ORM\JoinColumn(nullable: false)]
    private $largeFile;

    #[ORM\ManyToOne(targetEntity: ExpansionChip::class, inversedBy: 'drivers')]
    #[ORM\JoinColumn(nullable: false)]
    private $expansionChip;

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
    public function getExpansionChip(): ?ExpansionChip
    {
        return $this->expansionChip;
    }
    public function setExpansionChip(?ExpansionChip $expansionChip): self
    {
        $this->expansionChip = $expansionChip;

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
