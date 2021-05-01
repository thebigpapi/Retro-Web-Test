<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CreditorRepository")
 */
class Creditor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MotherboardImage", mappedBy="creditor")
     */
    private $motherboardImages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ChipImage", mappedBy="creditor")
     */
    private $chipImages;

    public function __construct()
    {
        $this->chipImages = new ArrayCollection();
        $this->license = new ArrayCollection();
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

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

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
            $motherboardImage->setCreditor($this);
        }

        return $this;
    }

    public function removeMotherboardImage(MotherboardImage $motherboardImage): self
    {
        if ($this->motherboardImages->contains($motherboardImage)) {
            $this->motherboardImages->removeElement($motherboardImage);
            // set the owning side to null (unless already changed)
            if ($motherboardImage->getCreditor() === $this) {
                $motherboardImage->setCreditor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChipImage[]
     */
    public function getLicense(): Collection
    {
        return $this->chipImages;
    }

    public function addLicense(ChipImage $chipImage): self
    {
        if (!$this->chipImages->contains($chipImage)) {
            $this->chipImages[] = $chipImage;
            $chipImage->setCreditor($this);
        }

        return $this;
    }

    public function removeLicense(ChipImage $chipImage): self
    {
        if ($this->chipImages->contains($chipImage)) {
            $this->chipImages->removeElement($chipImage);
            // set the owning side to null (unless already changed)
            if ($chipImage->getCreditor() === $this) {
                $chipImage->setCreditor(null);
            }
        }

        return $this;
    }
}
