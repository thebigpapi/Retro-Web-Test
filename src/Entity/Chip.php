<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ChipRepository')]
#[ORM\InheritanceType('JOINED')]
abstract class Chip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    protected $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Part number is longer than {{ limit }} characters, try to make it shorter.')]
    protected $partNumber;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'chips', fetch: 'EAGER')]
    protected $manufacturer;

    #[ORM\OneToMany(targetEntity: ChipDocumentation::class, mappedBy: 'chip', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    protected $documentations;

    #[ORM\OneToMany(targetEntity: ChipAlias::class, mappedBy: 'chip', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $chipAliases;

    #[ORM\OneToMany(targetEntity: ChipImage::class, mappedBy: 'chip', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $images;

    #[ORM\OneToMany(mappedBy: 'chip', targetEntity: PciDeviceId::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $pciDevs;

    #[ORM\Column(type: 'datetime')]
    private $lastEdited;


    public function __construct()
    {
        $this->chipAliases = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->pciDevs = new ArrayCollection();
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
    public function getPartNumber(): ?string
    {
        return $this->partNumber;
    }
    public function setPartNumber(string $partNumber): self
    {
        $this->partNumber = $partNumber;

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
            $chipAlias->setChip($this);
        }

        return $this;
    }
    public function removeChipAlias(ChipAlias $chipAlias): self
    {
        if ($this->chipAliases->contains($chipAlias)) {
            $this->chipAliases->removeElement($chipAlias);
            // set the owning side to null (unless already changed)
            if ($chipAlias->getChip() === $this) {
                $chipAlias->setChip(null);
            }
        }

        return $this;
    }
    public function addAlias(Manufacturer $manuf, ?string $name, string $partNumber): self
    {
        $cha = new ChipAlias();
        $cha->setManufacturer($manuf);
        $cha->setChip($this);
        $cha->setName($name);
        $cha->setPartNumber($partNumber);

        return $this->addChipAlias($cha);
    }
    /**
     * @return Collection|ChipImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }
    public function addImage(ChipImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setChip($this);
        }

        return $this;
    }
    public function removeImage(ChipImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getChip() === $this) {
                $image->setChip(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChipDocumentation[]
     */
    public function getDocumentations(): Collection
    {
        return $this->documentations;
    }
    public function addDocumentation(ChipDocumentation $documentation): self
    {
        if (!$this->documentations->contains($documentation)) {
            $this->documentations[] = $documentation;
            $documentation->setChip($this);
        }

        return $this;
    }
    public function removeDocumentation(ChipDocumentation $documentation): self
    {
        if ($this->documentations->contains($documentation)) {
            $this->documentations->removeElement($documentation);
            // set the owning side to null (unless already changed)
            if ($documentation->getChip() === $this) {
                $documentation->setChip(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PciDeviceId>
     */
    public function getPciDevs(): Collection
    {
        return $this->pciDevs;
    }

    public function addPciDev(PciDeviceId $pciDev): self
    {
        if (!$this->pciDevs->contains($pciDev)) {
            $this->pciDevs->add($pciDev);
            $pciDev->setChip($this);
        }

        return $this;
    }

    public function removePciDev(PciDeviceId $pciDev): self
    {
        if ($this->pciDevs->removeElement($pciDev)) {
            // set the owning side to null (unless already changed)
            if ($pciDev->getChip() === $this) {
                $pciDev->setChip(null);
            }
        }

        return $this;
    }
    public function getLastEdited(): ?\DateTimeInterface
    {
        return $this->lastEdited;
    }

    public function setLastEdited(\DateTimeInterface $lastEdited): self
    {
        $this->lastEdited = $lastEdited;

        return $this;
    }
    public function updateLastEdited()
    {
        $this->lastEdited = new \DateTime('now');
    }
}
