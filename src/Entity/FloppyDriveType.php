<?php

namespace App\Entity;

use App\Repository\FloppyDriveTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FloppyDriveTypeRepository::class)]
class FloppyDriveType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: FloppyDrive::class, mappedBy: 'type')]
    private Collection $floppyDrives;

    public function __construct()
    {
        $this->floppyDrives = new ArrayCollection();
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

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, FloppyDrive>
     */
    public function getFloppyDrives(): Collection
    {
        return $this->floppyDrives;
    }

    public function addFloppyDrive(FloppyDrive $floppyDrive): static
    {
        if (!$this->floppyDrives->contains($floppyDrive)) {
            $this->floppyDrives->add($floppyDrive);
            $floppyDrive->addType($this);
        }

        return $this;
    }

    public function removeFloppyDrive(FloppyDrive $floppyDrive): static
    {
        if ($this->floppyDrives->removeElement($floppyDrive)) {
            $floppyDrive->removeType($this);
        }

        return $this;
    }
}
