<?php

namespace App\Entity;

use App\Repository\LargeFileExpansionCardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LargeFileExpansionCardRepository::class)]
class LargeFileExpansionCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: LargeFile::class, inversedBy: 'expansionCards')]
    #[ORM\JoinColumn(nullable: false)]
    private $largeFile;

    #[ORM\ManyToOne(targetEntity: ExpansionCard::class, inversedBy: 'drivers')]
    #[ORM\JoinColumn(nullable: false)]
    private $expansionCard;

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
    public function getExpansionCard(): ?ExpansionCard
    {
        return $this->expansionCard;
    }
    public function setExpansionCard(?ExpansionCard $expansionCard): self
    {
        $this->expansionCard = $expansionCard;

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
