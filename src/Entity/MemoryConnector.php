<?php

namespace App\Entity;

use App\Repository\MemoryConnectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemoryConnectorRepository::class)]
class MemoryConnector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'memoryConnector', targetEntity: MotherboardMemoryConnector::class, orphanRemoval: true)]
    private Collection $motherboardMemoryConnectors;

    public function __construct()
    {
        $this->motherboardMemoryConnectors = new ArrayCollection();
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
     * @return Collection<int, MotherboardMemoryConnector>
     */
    public function getMotherboardMemoryConnectors(): Collection
    {
        return $this->motherboardMemoryConnectors;
    }

    public function addMotherboardMemoryConnector(MotherboardMemoryConnector $motherboardMemoryConnector): self
    {
        if (!$this->motherboardMemoryConnectors->contains($motherboardMemoryConnector)) {
            $this->motherboardMemoryConnectors->add($motherboardMemoryConnector);
            $motherboardMemoryConnector->setMemoryConnector($this);
        }

        return $this;
    }

    public function removeMotherboardMemoryConnector(MotherboardMemoryConnector $motherboardMemoryConnector): self
    {
        if ($this->motherboardMemoryConnectors->removeElement($motherboardMemoryConnector)) {
            // set the owning side to null (unless already changed)
            if ($motherboardMemoryConnector->getMemoryConnector() === $this) {
                $motherboardMemoryConnector->setMemoryConnector(null);
            }
        }

        return $this;
    }
}
