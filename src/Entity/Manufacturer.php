<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManufacturerRepository")
 */
class Manufacturer
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
    private $shortName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Motherboard", mappedBy="manufacturer")
     */
    private $motherboards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chipset", mappedBy="manufacturer")
     */
    private $chipsets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Processor", mappedBy="manufacturer")
     */
    private $processors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VideoChipset", mappedBy="manufacturer")
     */
    private $videoChipsets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AudioChipset", mappedBy="manufacturer")
     */
    private $audioChipsets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ChipsetPart", mappedBy="manufacturer")
     */
    private $chipsetParts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MotherboardAlias", mappedBy="manufacturer")
     */
    private $motherboardAliases;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->chipsets = new ArrayCollection();
        $this->processors = new ArrayCollection();
        $this->videoChipsets = new ArrayCollection();
        $this->audioChipsets = new ArrayCollection();
        $this->chipsetParts = new ArrayCollection();
        $this->motherboardAliases = new ArrayCollection();
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

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(?string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }
    
    public function getShortNameIfExist(): ?string
    {
        if($this->shortName){
            return $this->shortName;
        }
        return $this->name;
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
            $motherboard->setManufacturer($this);
        }

        return $this;
    }

    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            // set the owning side to null (unless already changed)
            if ($motherboard->getManufacturer() === $this) {
                $motherboard->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Chipset[]
     */
    public function getChipsets(): Collection
    {
        return $this->chipsets;
    }

    public function addChipset(Chipset $chipset): self
    {
        if (!$this->chipsets->contains($chipset)) {
            $this->chipsets[] = $chipset;
            $chipset->setManufacturer($this);
        }

        return $this;
    }

    public function removeChipset(Chipset $chipset): self
    {
        if ($this->chipsets->contains($chipset)) {
            $this->chipsets->removeElement($chipset);
            // set the owning side to null (unless already changed)
            if ($chipset->getManufacturer() === $this) {
                $chipset->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Processor[]
     */
    public function getProcessors(): Collection
    {
        return $this->processors;
    }

    public function addProcessor(Processor $processor): self
    {
        if (!$this->processors->contains($processor)) {
            $this->processors[] = $processor;
            $processor->setManufacturer($this);
        }

        return $this;
    }

    public function removeProcessor(Processor $processor): self
    {
        if ($this->processors->contains($processor)) {
            $this->processors->removeElement($processor);
            // set the owning side to null (unless already changed)
            if ($processor->getManufacturer() === $this) {
                $processor->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VideoChipset[]
     */
    public function getVideoChipsets(): Collection
    {
        return $this->videoChipsets;
    }

    public function addVideoChipset(VideoChipset $videoChipset): self
    {
        if (!$this->videoChipsets->contains($videoChipset)) {
            $this->videoChipsets[] = $videoChipset;
            $videoChipset->setManufacturer($this);
        }

        return $this;
    }

    public function removeVideoChipset(VideoChipset $videoChipset): self
    {
        if ($this->videoChipsets->contains($videoChipset)) {
            $this->videoChipsets->removeElement($videoChipset);
            // set the owning side to null (unless already changed)
            if ($videoChipset->getManufacturer() === $this) {
                $videoChipset->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AudioChipset[]
     */
    public function getAudioChipsets(): Collection
    {
        return $this->audioChipsets;
    }

    public function addAudioChipset(AudioChipset $audioChipset): self
    {
        if (!$this->audioChipsets->contains($audioChipset)) {
            $this->audioChipsets[] = $audioChipset;
            $audioChipset->setManufacturer($this);
        }

        return $this;
    }

    public function removeAudioChipset(AudioChipset $audioChipset): self
    {
        if ($this->audioChipsets->contains($audioChipset)) {
            $this->audioChipsets->removeElement($audioChipset);
            // set the owning side to null (unless already changed)
            if ($audioChipset->getManufacturer() === $this) {
                $audioChipset->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChipsetPart[]
     */
    public function getChipsetParts(): Collection
    {
        return $this->chipsetParts;
    }

    public function addChipsetPart(ChipsetPart $chipsetPart): self
    {
        if (!$this->chipsetParts->contains($chipsetPart)) {
            $this->chipsetParts[] = $chipsetPart;
            $chipsetPart->setManufacturer($this);
        }

        return $this;
    }

    public function removeChipsetPart(ChipsetPart $chipsetPart): self
    {
        if ($this->chipsetParts->contains($chipsetPart)) {
            $this->chipsetParts->removeElement($chipsetPart);
            // set the owning side to null (unless already changed)
            if ($chipsetPart->getManufacturer() === $this) {
                $chipsetPart->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MotherboardAlias[]
     */
    public function getMotherboardAliases(): Collection
    {
        return $this->motherboardAliases;
    }

    public function addMotherboardAlias(MotherboardAlias $motherboardAlias): self
    {
        if (!$this->motherboardAliases->contains($motherboardAlias)) {
            $this->motherboardAliases[] = $motherboardAlias;
            $motherboardAlias->setManufacturer($this);
        }

        return $this;
    }

    public function removeMotherboardAlias(MotherboardAlias $motherboardAlias): self
    {
        if ($this->motherboardAliases->contains($motherboardAlias)) {
            $this->motherboardAliases->removeElement($motherboardAlias);
            // set the owning side to null (unless already changed)
            if ($motherboardAlias->getManufacturer() === $this) {
                $motherboardAlias->setManufacturer(null);
            }
        }

        return $this;
    }
}
