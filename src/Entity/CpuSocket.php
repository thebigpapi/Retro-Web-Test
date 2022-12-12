<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\CpuSocketRepository')]
class CpuSocket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max:255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\ManyToMany(targetEntity: 'App\Entity\ProcessorPlatformType', inversedBy: 'cpuSockets')]
    private $platforms;

    #[ORM\ManyToMany(targetEntity: 'App\Entity\Motherboard', mappedBy: 'cpuSockets')]
    private $motherboards;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max:255, maxMessage: 'Type is longer than {{ limit }} characters, try to make it shorter.')]
    private $type;

    #[ORM\ManyToMany(targetEntity: 'App\Entity\ProcessingUnit', mappedBy: 'sockets')]
    private $processingUnits;

    public function __construct()
    {
        $this->platforms = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
        $this->processingUnits = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return Collection|ProcessorPlatformType[]
     */
    public function getPlatforms(): Collection
    {
        return $this->platforms;
    }
    public function addPlatform(ProcessorPlatformType $platform): self
    {
        if (!$this->platforms->contains($platform)) {
            $this->platforms[] = $platform;
        }

        return $this;
    }
    public function removePlatform(ProcessorPlatformType $platform): self
    {
        if ($this->platforms->contains($platform)) {
            $this->platforms->removeElement($platform);
        }

        return $this;
    }
    /**
     * @return Collection|Motherboard[]
     */
    public function getMotherboards(): Collection
    {
        return $this->motherboards;
    }
    public function addMotherboard(Motherboard $motherboard): self
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
        }

        return $this;
    }
    public function getType(): ?string
    {
        return $this->type;
    }
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getNameAndType(): ?string
    {
        if($this->name) return "$this->name ($this->type)";
        else return $this->type;
    }
    /**
     * @return Collection|ProcessingUnit[]
     */
    public function getProcessingUnits(): Collection
    {
        return $this->processingUnits;
    }
    public function addProcessingUnit(ProcessingUnit $processingUnit): self
    {
        if (!$this->processingUnits->contains($processingUnit)) {
            $this->processingUnits[] = $processingUnit;
            $processingUnit->addSocket($this);
        }

        return $this;
    }
    public function removeProcessingUnit(ProcessingUnit $processingUnit): self
    {
        if ($this->processingUnits->contains($processingUnit)) {
            $this->processingUnits->removeElement($processingUnit);
            $processingUnit->removeSocket($this);
        }

        return $this;
    }
}
