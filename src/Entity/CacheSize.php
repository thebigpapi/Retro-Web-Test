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

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
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
}
