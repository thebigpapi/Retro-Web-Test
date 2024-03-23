<?php

namespace App\Entity;

use App\Repository\FloppyDriveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FloppyDriveRepository::class)]
class FloppyDrive extends StorageDevice
{

    #[ORM\Column(type: 'datetime', mapped: false)]
    private $lastEdited;

    #[ORM\ManyToMany(targetEntity: FloppyDriveType::class, inversedBy: 'floppyDrives')]
    private Collection $type;

    public function __construct()
    {
        parent::__construct();
        $this->type = new ArrayCollection();
    }

    /**
     * @return Collection<int, FloppyDriveType>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(FloppyDriveType $type): static
    {
        if (!$this->type->contains($type)) {
            $this->type->add($type);
        }

        return $this;
    }

    public function removeType(FloppyDriveType $type): static
    {
        $this->type->removeElement($type);

        return $this;
    }
}
