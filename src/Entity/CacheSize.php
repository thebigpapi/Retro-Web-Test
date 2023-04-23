<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CacheSizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CacheSizeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'read:CacheSize:item'],
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => ['read:CacheSize:list']]],
        'post' => ['denormalization_context' => ['groups' => 'write:CacheSize']]
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:CacheSize:item']],
        'put' => ['denormalization_context' => ['groups' => 'write:CacheSize']],
        'delete'
    ],
    order: ['name' => 'ASC'],
    paginationEnabled: true,
)]
class CacheSize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:CacheSize:list', 'read:CacheSize:item'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    #[Groups(['read:CacheSize:list', 'read:CacheSize:item', 'write:CacheSize'])]
    private $value;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'cacheSize')]
    private $motherboards;

    #[ORM\OneToMany(targetEntity: Processor::class, mappedBy: 'L1')]
    private $getProcessorsL1;

    #[ORM\OneToMany(targetEntity: Processor::class, mappedBy: 'L2')]
    private $getProcessorsL2;

    #[ORM\OneToMany(targetEntity: Processor::class, mappedBy: 'L3')]
    private $getProcessorsL3;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->getProcessorsL1 = new ArrayCollection();
        $this->getProcessorsL2 = new ArrayCollection();
        $this->getProcessorsL3 = new ArrayCollection();
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
     * @return Collection|Processor[]
     */
    public function getGetProcessorsL1(): Collection
    {
        return $this->getProcessorsL1;
    }
    public function addGetProcessorsL1(Processor $getProcessorsL1): self
    {
        if (!$this->getProcessorsL1->contains($getProcessorsL1)) {
            $this->getProcessorsL1[] = $getProcessorsL1;
            $getProcessorsL1->setL1($this);
        }

        return $this;
    }
    public function removeGetProcessorsL1(Processor $getProcessorsL1): self
    {
        if ($this->getProcessorsL1->contains($getProcessorsL1)) {
            $this->getProcessorsL1->removeElement($getProcessorsL1);
            // set the owning side to null (unless already changed)
            if ($getProcessorsL1->getL1() === $this) {
                $getProcessorsL1->setL1(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Processor[]
     */
    public function getGetProcessorsL2(): Collection
    {
        return $this->getProcessorsL2;
    }
    public function addGetProcessorsL2(Processor $getProcessorsL2): self
    {
        if (!$this->getProcessorsL2->contains($getProcessorsL2)) {
            $this->getProcessorsL2[] = $getProcessorsL2;
            $getProcessorsL2->setL2($this);
        }

        return $this;
    }
    public function removeGetProcessorsL2(Processor $getProcessorsL2): self
    {
        if ($this->getProcessorsL2->contains($getProcessorsL2)) {
            $this->getProcessorsL2->removeElement($getProcessorsL2);
            // set the owning side to null (unless already changed)
            if ($getProcessorsL2->getL2() === $this) {
                $getProcessorsL2->setL2(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Processor[]
     */
    public function getGetProcessorsL3(): Collection
    {
        return $this->getProcessorsL3;
    }
    public function addGetProcessorsL3(Processor $getProcessorsL3): self
    {
        if (!$this->getProcessorsL3->contains($getProcessorsL3)) {
            $this->getProcessorsL3[] = $getProcessorsL3;
            $getProcessorsL3->setL3($this);
        }

        return $this;
    }
    public function removeGetProcessorsL3(Processor $getProcessorsL3): self
    {
        if ($this->getProcessorsL3->contains($getProcessorsL3)) {
            $this->getProcessorsL3->removeElement($getProcessorsL3);
            // set the owning side to null (unless already changed)
            if ($getProcessorsL3->getL3() === $this) {
                $getProcessorsL3->setL3(null);
            }
        }

        return $this;
    }
}
