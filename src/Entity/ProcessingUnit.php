<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: 'App\Repository\ProcessingUnitRepository')]
#[ORM\InheritanceType('JOINED')]
abstract class ProcessingUnit extends Chip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\ManyToOne(targetEntity: CpuSpeed::class, inversedBy: 'processingUnits')]
    #[ORM\OrderBy(['value' => 'ASC'])]
    protected $speed;

    #[ORM\ManyToOne(targetEntity: ProcessorPlatformType::class, inversedBy: 'processingUnits')]
    protected $platform;

    #[ORM\ManyToOne(targetEntity: CpuSpeed::class, inversedBy: 'processingUnitsFsb')]
    #[ORM\OrderBy(['value' => 'ASC'])]
    protected $fsb;

    #[ORM\ManyToMany(targetEntity: CpuSocket::class, inversedBy: 'processingUnits')]
    private $sockets;

    public function __construct()
    {
        parent::__construct();
        $this->sockets = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getSpeed(): ?CpuSpeed
    {
        return $this->speed;
    }
    public function setSpeed(?CpuSpeed $speed): self
    {
        $this->speed = $speed;

        return $this;
    }
    public function getPlatform(): ?ProcessorPlatformType
    {
        return $this->platform;
    }
    public function setPlatform(?ProcessorPlatformType $platform): self
    {
        $this->platform = $platform;

        return $this;
    }
    public function getFsb(): ?CpuSpeed
    {
        return $this->fsb;
    }
    public function setFsb(?CpuSpeed $fsb): self
    {
        $this->fsb = $fsb;

        return $this;
    }
    /**
     * @return Collection|CpuSocket[]
     */
    public function getSockets(): Collection
    {
        return $this->sockets;
    }
    public function addSocket(CpuSocket $socket): self
    {
        if (!$this->sockets->contains($socket)) {
            $this->sockets[] = $socket;
        }

        return $this;
    }
    public function removeSocket(CpuSocket $socket): self
    {
        if ($this->sockets->contains($socket)) {
            $this->sockets->removeElement($socket);
        }

        return $this;
    }
}
