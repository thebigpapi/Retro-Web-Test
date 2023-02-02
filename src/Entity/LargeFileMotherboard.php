<?php

namespace App\Entity;

use App\Repository\LargeFileMotherboardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LargeFileMotherboardRepository::class)]
class LargeFileMotherboard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: LargeFile::class, inversedBy: 'motherboards')]
    #[ORM\JoinColumn(nullable: false)]
    private $largeFile;

    #[ORM\ManyToOne(targetEntity: Motherboard::class, inversedBy: 'drivers')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;

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
    public function getMotherboard(): ?Motherboard
    {
        return $this->motherboard;
    }
    public function setMotherboard(?Motherboard $motherboard): self
    {
        $this->motherboard = $motherboard;

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
