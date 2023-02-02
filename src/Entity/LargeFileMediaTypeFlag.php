<?php

namespace App\Entity;

use App\Repository\LargeFileMediaTypeFlagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LargeFileMediaTypeFlagRepository::class)]
class LargeFileMediaTypeFlag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: LargeFile::class, inversedBy: 'mediaTypeFlags')]
    #[ORM\JoinColumn(nullable: false)]
    private $largeFile;

    #[ORM\ManyToOne(targetEntity: MediaTypeFlag::class, inversedBy: 'getLargeFiles')]
    #[ORM\JoinColumn(nullable: false)]
    private $mediaTypeFlag;

    #[ORM\Column(type: 'integer')]
    private $count;

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
    public function getMediaTypeFlag(): ?MediaTypeFlag
    {
        return $this->mediaTypeFlag;
    }
    public function setMediaTypeFlag(?MediaTypeFlag $mediaTypeFlag): self
    {
        $this->mediaTypeFlag = $mediaTypeFlag;

        return $this;
    }
    public function getCount(): ?int
    {
        return $this->count;
    }
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
