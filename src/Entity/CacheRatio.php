<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\CacheRatioRepository')]
class CacheRatio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(targetEntity: 'App\Entity\Processor', mappedBy: 'L2CacheRatio')]
    private $processorsL2;

    #[ORM\OneToMany(targetEntity: 'App\Entity\Processor', mappedBy: 'L3CacheRatio')]
    private $processorsL3;

    public function __construct()
    {
        $this->processorsL2 = new ArrayCollection();
        $this->processorsL3 = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return Collection|Processor[]
     */
    public function getProcessorsL2(): Collection
    {
        return $this->processorsL2;
    }
    public function addProcessorsL2(Processor $processorsL2): self
    {
        if (!$this->processorsL2->contains($processorsL2)) {
            $this->processorsL2[] = $processorsL2;
            $processorsL2->setL2CacheRatio($this);
        }

        return $this;
    }
    public function removeProcessorsL2(Processor $processorsL2): self
    {
        if ($this->processorsL2->contains($processorsL2)) {
            $this->processorsL2->removeElement($processorsL2);
            // set the owning side to null (unless already changed)
            if ($processorsL2->getL2CacheRatio() === $this) {
                $processorsL2->setL2CacheRatio(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Processor[]
     */
    public function getProcessorsL3(): Collection
    {
        return $this->processorsL3;
    }
    public function addProcessorsL3(Processor $processorsL3): self
    {
        if (!$this->processorsL3->contains($processorsL3)) {
            $this->processorsL3[] = $processorsL3;
            $processorsL3->setL3CacheRatio($this);
        }

        return $this;
    }
    public function removeProcessorsL3(Processor $processorsL3): self
    {
        if ($this->processorsL3->contains($processorsL3)) {
            $this->processorsL3->removeElement($processorsL3);
            // set the owning side to null (unless already changed)
            if ($processorsL3->getL3CacheRatio() === $this) {
                $processorsL3->setL3CacheRatio(null);
            }
        }

        return $this;
    }
}
