<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManufacturerRepository")
 * @UniqueEntity("name")
 * @UniqueEntity("shortName")
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
     * @Assert\NotBlank
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chip", mappedBy="Manufacturer")
     */
    private $chips;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ChipAlias", mappedBy="manufacturer")
     */
    private $chipAliases;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ManufacturerBiosManufacturerCode", mappedBy="manufacturer", orphanRemoval=true, cascade={"persist"})
     */
    private $biosCodes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ChipsetBiosCode", mappedBy="biosManufacturer")
     */
    private $chipsetBiosCodes;

    /**
     * @ORM\OneToMany(targetEntity=OsFlag::class, mappedBy="manufacturer")
     */
    private $osFlags;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->chipsets = new ArrayCollection();
        $this->processors = new ArrayCollection();
        $this->videoChipsets = new ArrayCollection();
        $this->audioChipsets = new ArrayCollection();
        $this->chipsetParts = new ArrayCollection();
        $this->motherboardAliases = new ArrayCollection();
        $this->chips = new ArrayCollection();
        $this->chipAliases = new ArrayCollection();
        $this->biosCodes = new ArrayCollection();
        $this->chipsetBiosCodes = new ArrayCollection();
        $this->osFlags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
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

    /**
     * @return Collection|Chip[]
     */
    public function getChips(): Collection
    {
        return $this->chips;
    }

    public function addChip(Chip $chip): self
    {
        if (!$this->chips->contains($chip)) {
            $this->chips[] = $chip;
            $chip->setManufacturer($this);
        }

        return $this;
    }

    public function removeChip(Chip $chip): self
    {
        if ($this->chips->contains($chip)) {
            $this->chips->removeElement($chip);
            // set the owning side to null (unless already changed)
            if ($chip->getManufacturer() === $this) {
                $chip->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChipAlias[]
     */
    public function getChipAliases(): Collection
    {
        return $this->chipAliases;
    }

    public function addChipAlias(ChipAlias $chipAlias): self
    {
        if (!$this->chipAliases->contains($chipAlias)) {
            $this->chipAliases[] = $chipAlias;
            $chipAlias->setManufacturer($this);
        }

        return $this;
    }

    public function removeChipAlias(ChipAlias $chipAlias): self
    {
        if ($this->chipAliases->contains($chipAlias)) {
            $this->chipAliases->removeElement($chipAlias);
            // set the owning side to null (unless already changed)
            if ($chipAlias->getManufacturer() === $this) {
                $chipAlias->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ManufacturerBiosManufacturerCode[]
     */
    public function getBiosCodes(): Collection
    {
        return $this->biosCodes;
    }

    public function addBiosCode(ManufacturerBiosManufacturerCode $biosCode): self
    {
        if (!$this->biosCodes->contains($biosCode)) {
            $this->biosCodes[] = $biosCode;
            $biosCode->setManufacturer($this);
        }

        return $this;
    }

    public function removeBiosCode(ManufacturerBiosManufacturerCode $biosCode): self
    {
        if ($this->biosCodes->contains($biosCode)) {
            $this->biosCodes->removeElement($biosCode);
            // set the owning side to null (unless already changed)
            if ($biosCode->getManufacturer() === $this) {
                $biosCode->setManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChipsetBiosCode[]
     */
    public function getChipsetBiosCodes(): Collection
    {
        return $this->chipsetBiosCodes;
    }

    public function addChipsetBiosCode(ChipsetBiosCode $chipsetBiosCode): self
    {
        if (!$this->chipsetBiosCodes->contains($chipsetBiosCode)) {
            $this->chipsetBiosCodes[] = $chipsetBiosCode;
            $chipsetBiosCode->setBiosManufacturer($this);
        }

        return $this;
    }

    public function removeChipsetBiosCode(ChipsetBiosCode $chipsetBiosCode): self
    {
        if ($this->chipsetBiosCodes->contains($chipsetBiosCode)) {
            $this->chipsetBiosCodes->removeElement($chipsetBiosCode);
            // set the owning side to null (unless already changed)
            if ($chipsetBiosCode->getBiosManufacturer() === $this) {
                $chipsetBiosCode->setBiosManufacturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OsFlag[]
     */
    public function getOsFlags(): Collection
    {
        return $this->osFlags;
    }

    public function addOsFlag(OsFlag $osFlag): self
    {
        if (!$this->osFlags->contains($osFlag)) {
            $this->osFlags[] = $osFlag;
            $osFlag->setManufacturer($this);
        }

        return $this;
    }

    public function removeOsFlag(OsFlag $osFlag): self
    {
        if ($this->osFlags->removeElement($osFlag)) {
            // set the owning side to null (unless already changed)
            if ($osFlag->getManufacturer() === $this) {
                $osFlag->setManufacturer(null);
            }
        }

        return $this;
    }
}
