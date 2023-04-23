<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExpansionChipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpansionChipRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'read:ExpansionChip:item'],
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => ['read:ExpansionChip:list']]],
        'post' => ['denormalization_context' => ['groups' => 'write:ExpansionChip']]
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:ExpansionChip:item']],
        'put' => ['denormalization_context' => ['groups' => 'write:ExpansionChip']],
        'delete'
    ],
    order: ['name' => 'ASC'],
    paginationEnabled: false,
)]
class ExpansionChip extends Chip
{
    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'expansionChips')]
    private $motherboards;

    #[ORM\OneToMany(targetEntity: LargeFileExpansionChip::class, mappedBy: 'expansionChip', orphanRemoval: true, cascade: ['persist'])]
    private $drivers;

    #[ORM\ManyToOne(targetEntity: ExpansionChipType::class, inversedBy: 'expansionChips')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\Column(length: 4096, nullable: true)]
    #[Groups(['read:ExpansionChip:list', 'read:ExpansionChip:item', 'write:ExpansionChip'])]
    private ?string $description = null;

    public function __construct()
    {
        parent::__construct();
        $this->motherboards = new ArrayCollection();
        $this->drivers = new ArrayCollection();
        $this->documentations = new ArrayCollection();
    }
    #[Groups(['read:ExpansionChip:list', 'read:ExpansionChip:item'])]
    public function getId(): ?int
    {
        return $this->id;
    }
    #[Groups(['read:ExpansionChip:list', 'read:ExpansionChip:item'])]
    public function getName(): ?string
    {
        return $this->name;
    }
    #[Groups(['write:ExpansionChip'])]
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    #[Groups(['read:ExpansionChip:list', 'read:ExpansionChip:item'])]
    public function getPartNumber(): ?string
    {
        return $this->partNumber;
    }
    #[Groups(['write:ExpansionChip'])]
    public function setPartNumber(?string $partNumber): self
    {
        $this->partNumber = $partNumber;

        return $this;
    }
    #[Groups(['read:ExpansionChip:list', 'read:ExpansionChip:item'])]
    public function getType(): ?ExpansionChipType
    {
        return $this->type;
    }
    #[Groups(['write:ExpansionChip'])]
    public function setType(?ExpansionChipType $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getNameWithManufacturer()
    {
        if ($this->name) {
            if ($this->partNumber) {
                return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name . " (" . $this->partNumber . ")";
            }
            return $this->getManufacturer()->getShortNameIfExist() . " " . $this->name;
        }
        if ($this->partNumber) {
            return $this->getManufacturer()->getShortNameIfExist() . " " . $this->partNumber;
        }
        return $this->getManufacturer()->getShortNameIfExist() . " Unidentified";
    }
    /**
     * @return Collection|Motherboard[]
     */
    #[Groups(['read:ExpansionChip:list', 'read:ExpansionChip:item'])]
    public function getMotherboards(): Collection
    {
        return $this->motherboards;
    }
    public function addMotherboard(Motherboard $motherboard): self
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->addExpansionChip($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->removeElement($motherboard)) {
            $motherboard->removeExpansionChip($this);
        }

        return $this;
    }
    #[Groups(['read:ExpansionChip:list', 'read:ExpansionChip:item'])]
    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }
    #[Groups(['write:ExpansionChip'])]
    public function setManufacturer(?Manufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }
    /**
     * @return Collection|LargeFileExpansionChip[]
     */
    #[Groups(['read:ExpansionChip:list', 'read:ExpansionChip:item'])]
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }
    public function addDriver(LargeFileExpansionChip $driver): self
    {
        if (!$this->drivers->contains($driver)) {
            $this->drivers[] = $driver;
            $driver->setExpansionChip($this);
        }

        return $this;
    }
    public function removeDriver(LargeFileExpansionChip $driver): self
    {
        if ($this->drivers->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getExpansionChip() === $this) {
                $driver->setExpansionChip(null);
            }
        }

        return $this;
    }

    public function getExpansionChipType(): ?ExpansionChipType
    {
        return $this->type;
    }
    public function setExpansionChipType(?ExpansionChipType $type): self
    {
        $this->type = $type;

        return $this;
    }

    #[Groups(['read:ExpansionChip:list', 'read:ExpansionChip:item'])]
    public function getDescription(): ?string
    {
        return $this->description;
    }
    #[Groups(['write:ExpansionChip'])]
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
