<?php

namespace App\Entity;

use App\Repository\LargeFileAudioChipsetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LargeFileAudioChipsetRepository::class)]
class LargeFileAudioChipset
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\ManyToOne(targetEntity: LargeFile::class, inversedBy: 'audioChipsets')]
    #[ORM\JoinColumn(nullable: false)]
    private $largeFile;

    #[ORM\ManyToOne(targetEntity: AudioChipset::class, inversedBy: 'drivers')]
    #[ORM\JoinColumn(nullable: false)]
    private $audioChipset;

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
    public function getAudioChipset(): ?AudioChipset
    {
        return $this->audioChipset;
    }
    public function setAudioChipset(?AudioChipset $audioChipset): self
    {
        $this->audioChipset = $audioChipset;

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
