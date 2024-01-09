<?php

namespace App\Entity;

use App\Repository\ExpansionCardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpansionCardRepository::class)]
class ExpansionCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: ExpansionChip::class, inversedBy: 'expansionCards')]
    private Collection $expansionChips;

    #[ORM\ManyToMany(targetEntity: PSUConnector::class, inversedBy: 'expansionCards')]
    private Collection $powerConnectors;

    #[ORM\Column(length: 4096, nullable: true)]
    #[Assert\Length(max: 4096, maxMessage: 'Description is longer than {{ limit }} characters, try to make it shorter.')]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: LargeFileExpansionCard::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $drivers;

    #[ORM\OneToMany(targetEntity: ExpansionCardDocumentation::class, mappedBy: 'expansionCard', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    protected $documentations;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardImage::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: ExpansionCardType::class, inversedBy: 'expansionCards')]
    private Collection $type;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardAlias::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $expansionCardAliases;

    #[ORM\ManyToOne(inversedBy: 'expansionCards')]
    private ?Manufacturer $manufacturer = null;

    #[ORM\OneToMany(mappedBy: 'expansionCard', targetEntity: ExpansionCardBios::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $expansionCardBios;

    #[ORM\Column(type: 'datetime')]
    private $lastEdited;

    public function __construct()
    {
        $this->expansionChips = new ArrayCollection();
        $this->powerConnectors = new ArrayCollection();
        $this->documentations = new ArrayCollection();
        $this->drivers = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->type = new ArrayCollection();
        $this->expansionCardAliases = new ArrayCollection();
        $this->expansionCardBios = new ArrayCollection();
        $this->lastEdited = new \DateTime('now');
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
    public function getPrettyTitle(): string
    {
        $strBuilder = "";
        $mfgData = $this->getManufacturer();
        if ($mfgData != null) {
            $strBuilder .= $mfgData->getName();
        } else {
            $strBuilder .= "[Unknown]";
        }
        $strBuilder .= " " . $this->getName();
        return $strBuilder;
    }

    /**
     * @return Collection<int, ExpansionChip>
     */
    public function getExpansionChips(): Collection
    {
        return $this->expansionChips;
    }

    public function addExpansionChip(ExpansionChip $expansionChip): static
    {
        if (!$this->expansionChips->contains($expansionChip)) {
            $this->expansionChips->add($expansionChip);
        }

        return $this;
    }

    public function removeExpansionChip(ExpansionChip $expansionChip): static
    {
        $this->expansionChips->removeElement($expansionChip);

        return $this;
    }

    /**
     * @return Collection<int, PSUConnector>
     */
    public function getPowerConnectors(): Collection
    {
        return $this->powerConnectors;
    }

    public function addPowerConnector(PSUConnector $powerConnector): static
    {
        if (!$this->powerConnectors->contains($powerConnector)) {
            $this->powerConnectors->add($powerConnector);
        }

        return $this;
    }

    public function removePowerConnector(PSUConnector $powerConnector): static
    {
        $this->powerConnectors->removeElement($powerConnector);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, LargeFileExpansionCard>
     */
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }

    public function addDriver(LargeFileExpansionCard $driver): static
    {
        if (!$this->drivers->contains($driver)) {
            $this->drivers->add($driver);
            $driver->setExpansionCard($this);
        }

        return $this;
    }

    public function removeDriver(LargeFileExpansionCard $driver): static
    {
        if ($this->drivers->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getExpansionCard() === $this) {
                $driver->setExpansionCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCardImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ExpansionCardImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setExpansionCard($this);
        }

        return $this;
    }

    public function removeImage(ExpansionCardImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getExpansionCard() === $this) {
                $image->setExpansionCard(null);
            }
        }

        return $this;
    }

    public function isExpansionCardImage(): bool
    {
        if(isset($this->images))
            if(count($this->images) > 0)
                return true;
        return false;
    }
    /**
     * @return Collection|ExpansionCardDocumentation[]
     */
    public function getDocumentations(): Collection
    {
        return $this->documentations;
    }
    public function addDocumentation(ExpansionCardDocumentation $documentation): self
    {
        if (!$this->documentations->contains($documentation)) {
            $this->documentations[] = $documentation;
            $documentation->setExpansionCard($this);
        }

        return $this;
    }
    public function removeDocumentation(ExpansionCardDocumentation $documentation): self
    {
        if ($this->documentations->contains($documentation)) {
            $this->documentations->removeElement($documentation);
            // set the owning side to null (unless already changed)
            if ($documentation->getExpansionCard() === $this) {
                $documentation->setExpansionCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCardType>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(ExpansionCardType $type): static
    {
        if (!$this->type->contains($type)) {
            $this->type->add($type);
        }

        return $this;
    }

    public function removeType(ExpansionCardType $type): static
    {
        $this->type->removeElement($type);

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCardAlias>
     */
    public function getExpansionCardAliases(): Collection
    {
        return $this->expansionCardAliases;
    }

    public function addExpansionCardAlias(ExpansionCardAlias $expansionCardAlias): static
    {
        if (!$this->expansionCardAliases->contains($expansionCardAlias)) {
            $this->expansionCardAliases->add($expansionCardAlias);
            $expansionCardAlias->setExpansionCard($this);
        }

        return $this;
    }

    public function removeExpansionCardAlias(ExpansionCardAlias $expansionCardAlias): static
    {
        if ($this->expansionCardAliases->removeElement($expansionCardAlias)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardAlias->getExpansionCard() === $this) {
                $expansionCardAlias->setExpansionCard(null);
            }
        }

        return $this;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): static
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCardBios>
     */
    public function getExpansionCardBios(): Collection
    {
        return $this->expansionCardBios;
    }

    public function addExpansionCardBio(ExpansionCardBios $expansionCardBio): static
    {
        if (!$this->expansionCardBios->contains($expansionCardBio)) {
            $this->expansionCardBios->add($expansionCardBio);
            $expansionCardBio->setExpansionCard($this);
        }

        return $this;
    }

    public function removeExpansionCardBio(ExpansionCardBios $expansionCardBio): static
    {
        if ($this->expansionCardBios->removeElement($expansionCardBio)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardBio->getExpansionCard() === $this) {
                $expansionCardBio->setExpansionCard(null);
            }
        }

        return $this;
    }
    public function isExpansionCardBios(): bool
    {
        if(isset($this->expansionCardBios))
            if(count($this->expansionCardBios) > 0)
                return true;
        return false;
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
