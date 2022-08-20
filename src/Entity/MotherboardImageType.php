<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\MotherboardImageTypeRepository')]
class MotherboardImageType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'string', length: 255)]
    private $name;
    #[ORM\OneToMany(targetEntity: 'App\Entity\MotherboardImage', mappedBy: 'motherboardImageType')]
    private $motherboardImages;
    public function __construct()
    {
        $this->motherboardImages = new ArrayCollection();
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
     * @return Collection|MotherboardImage[]
     */
    public function getMotherboardImages(): Collection
    {
        return $this->motherboardImages;
    }
    public function addMotherboardImage(MotherboardImage $motherboardImage): self
    {
        if (!$this->motherboardImages->contains($motherboardImage)) {
            $this->motherboardImages[] = $motherboardImage;
            $motherboardImage->setMotherboardImageType($this);
        }

        return $this;
    }
    public function removeMotherboardImage(MotherboardImage $motherboardImage): self
    {
        if ($this->motherboardImages->contains($motherboardImage)) {
            $this->motherboardImages->removeElement($motherboardImage);
            // set the owning side to null (unless already changed)
            if ($motherboardImage->getMotherboardImageType() === $this) {
                $motherboardImage->setMotherboardImageType(null);
            }
        }

        return $this;
    }
}
