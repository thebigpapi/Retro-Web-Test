<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\LicenseRepository')]
class License
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(targetEntity: 'App\Entity\MotherboardImage', mappedBy: 'license')]
    private $motherboardImages;
    
    #[ORM\OneToMany(targetEntity: 'App\Entity\ChipImage', mappedBy: 'license')]
    private $chipImages;

    #[ORM\OneToMany(targetEntity: 'App\Entity\ChipImage', mappedBy: 'license')]
    private $creditors;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    public function __construct()
    {
        $this->motherboardImages = new ArrayCollection();
        $this->chipImages = new ArrayCollection();
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
            $motherboardImage->setLicense($this);
        }

        return $this;
    }
    public function removeMotherboardImage(MotherboardImage $motherboardImage): self
    {
        if ($this->motherboardImages->contains($motherboardImage)) {
            $this->motherboardImages->removeElement($motherboardImage);
            // set the owning side to null (unless already changed)
            if ($motherboardImage->getLicense() === $this) {
                $motherboardImage->setLicense(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|ChipImage[]
     */
    public function getChipImages(): Collection
    {
        return $this->chipImages;
    }
    public function addChipImage(ChipImage $chipImage): self
    {
        if (!$this->chipImages->contains($chipImage)) {
            $this->chipImages[] = $chipImage;
            $chipImage->setLicense($this);
        }

        return $this;
    }
    public function removeChipImage(ChipImage $chipImage): self
    {
        if ($this->chipImages->contains($chipImage)) {
            $this->chipImages->removeElement($chipImage);
            // set the owning side to null (unless already changed)
            if ($chipImage->getLicense() === $this) {
                $chipImage->setLicense(null);
            }
        }

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }
}
