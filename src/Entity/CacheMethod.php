<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\CacheMethodRepository')]
class CacheMethod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'string', length: 255)]
    private $name;
    #[ORM\OneToMany(targetEntity: 'App\Entity\Processor', mappedBy: 'L1CacheMethod')]
    private $processors;
    public function __construct()
    {
        $this->processors = new ArrayCollection();
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
    public function getProcessors(): Collection
    {
        return $this->processors;
    }
    public function addProcessor(Processor $processor): self
    {
        if (!$this->processors->contains($processor)) {
            $this->processors[] = $processor;
            $processor->setL1CacheMethod($this);
        }

        return $this;
    }
    public function removeProcessor(Processor $processor): self
    {
        if ($this->processors->contains($processor)) {
            $this->processors->removeElement($processor);
            // set the owning side to null (unless already changed)
            if ($processor->getL1CacheMethod() === $this) {
                $processor->setL1CacheMethod(null);
            }
        }

        return $this;
    }
}
