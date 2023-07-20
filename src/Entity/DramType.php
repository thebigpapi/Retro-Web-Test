<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\DramTypeRepository')]
class DramType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'dramType')]
    private $motherboards;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->name;
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
            $motherboard->addDramType($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            $motherboard->removeDramType($this);
        }

        return $this;
    }
}
