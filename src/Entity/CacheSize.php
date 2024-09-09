<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\CacheSizeRepository')]
class CacheSize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    private $value;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'cacheSize')]
    private $motherboards;

    #[ORM\OneToMany(targetEntity: ProcessorPlatformType::class, mappedBy: 'L1data')]
    private $getProcessorsL1data;

    #[ORM\OneToMany(targetEntity: ProcessorPlatformType::class, mappedBy: 'L1code')]
    private $getProcessorsL1code;


    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->getProcessorsL1code = new ArrayCollection();
        $this->getProcessorsL1data = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getValueWithUnit();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getValue(): ?int
    {
        return $this->value;
    }
    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
    public function getValueWithUnit(): ?string
    {
        $val = $this->value;
        if ($val >= 1024) {
            $val = round($val / 1024, 2);
            if ($val >= 1024) {
                return (round($val / 1024, 2) . 'MB');
            } else {
                return $val . 'KB';
            }
        } else {
            return $val . 'B';
        }
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
            $motherboard->addCacheSize($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            $motherboard->removeCacheSize($this);
        }

        return $this;
    }
    /**
     * @return Collection|ProcessorPlatformType[]
     */
    public function getGetProcessorsL1data(): Collection
    {
        return $this->getProcessorsL1data;
    }
    public function addGetProcessorsL1data(ProcessorPlatformType $getProcessorsL1data): self
    {
        if (!$this->getProcessorsL1data->contains($getProcessorsL1data)) {
            $this->getProcessorsL1data[] = $getProcessorsL1data;
            $getProcessorsL1data->setL1data($this);
        }

        return $this;
    }
    public function removeGetProcessorsL1(ProcessorPlatformType $getProcessorsL1data): self
    {
        if ($this->getProcessorsL1data->contains($getProcessorsL1data)) {
            $this->getProcessorsL1data->removeElement($getProcessorsL1data);
            // set the owning side to null (unless already changed)
            if ($getProcessorsL1data->getL1data() === $this) {
                $getProcessorsL1data->setL1data(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|ProcessorPlatformType[]
     */
    public function getGetProcessorsL1code(): Collection
    {
        return $this->getProcessorsL1code;
    }
    public function addGetProcessorsL1code(ProcessorPlatformType $getProcessorsL1code): self
    {
        if (!$this->getProcessorsL1code->contains($getProcessorsL1code)) {
            $this->getProcessorsL1code[] = $getProcessorsL1code;
            $getProcessorsL1code->setL1code($this);
        }

        return $this;
    }
    public function removeGetProcessorsL1code(ProcessorPlatformType $getProcessorsL1code): self
    {
        if ($this->getProcessorsL1code->contains($getProcessorsL1code)) {
            $this->getProcessorsL1code->removeElement($getProcessorsL1code);
            // set the owning side to null (unless already changed)
            if ($getProcessorsL1code->getL1code() === $this) {
                $getProcessorsL1code->setL1code(null);
            }
        }

        return $this;
    }
}
