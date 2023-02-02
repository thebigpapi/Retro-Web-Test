<?php

namespace App\Entity;

use App\Repository\LargeFileOsFlagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LargeFileOsFlagRepository::class)]
class LargeFileOsFlag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: LargeFile::class, inversedBy: 'osFlags')]
    #[ORM\JoinColumn(nullable: false)]
    private $largeFile;

    #[ORM\ManyToOne(targetEntity: OsFlag::class, inversedBy: 'largeFiles')]
    #[ORM\JoinColumn(nullable: false)]
    private $osFlag;

    #[ORM\Column(type: 'boolean')]
    private $unsure;

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
    public function getOsFlag(): ?OsFlag
    {
        return $this->osFlag;
    }
    public function setOsFlag(?OsFlag $osFlag): self
    {
        $this->osFlag = $osFlag;

        return $this;
    }
    public function getUnsure(): ?bool
    {
        return $this->unsure;
    }
    public function setUnsure(bool $unsure): self
    {
        $this->unsure = $unsure;

        return $this;
    }
}
