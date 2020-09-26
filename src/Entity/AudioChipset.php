<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AudioChipsetRepository")
 */
class AudioChipset
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Motherboard", mappedBy="audioChipset")
     */
    private $motherboards;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manufacturer", inversedBy="audioChipsets")
     */
    private $manufacturer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $chipName;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNameWithManufacturer()
    {
        if ($this->name) {
            if($this->chipName) {
                return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name . " (" . $this->chipName . ")";
            }
            return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name;
        }
        if($this->chipName) {
            return $this->getManufacturer()->getShortNameIfExist() . " " . $this->chipName;
        }
        return $this->getManufacturer()->getShortNameIfExist() . " Unidentified";
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
            $motherboard->setAudioChipset($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            // set the owning side to null (unless already changed)
            if ($motherboard->getAudioChipset() === $this) {
                $motherboard->setAudioChipset(null);
            }
        }

        return $this;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getChipName(): ?string
    {
        return $this->chipName;
    }

    public function setChipName(?string $chipName): self
    {
        $this->chipName = $chipName;

        return $this;
    }
}
