<?php

namespace App\Entity;

use App\Entity\Enum\KnownIssueType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\KnownIssueRepository')]
class KnownIssue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    private $name;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'knownIssues')]
    private $motherboards;

    #[ORM\Column(type: 'string', length: 512, nullable: true)]
    #[Assert\Length(max: 512, maxMessage: 'Description is longer than {{ limit }} characters.')]
    private $description;

    #[ORM\ManyToMany(targetEntity: StorageDevice::class, mappedBy: 'knownIssues')]
    private Collection $storageDevices;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $type = null;

    #[ORM\ManyToMany(targetEntity: ExpansionCard::class, mappedBy: 'knownIssues')]
    private Collection $expansionCards;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->storageDevices = new ArrayCollection();
        $this->expansionCards = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
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
            $motherboard->addKnownIssue($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            $motherboard->removeKnownIssue($this);
        }

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, StorageDevice>
     */
    public function getStorageDevices(): Collection
    {
        return $this->storageDevices;
    }

    public function addStorageDevice(StorageDevice $storageDevice): self
    {
        if (!$this->storageDevices->contains($storageDevice)) {
            $this->storageDevices->add($storageDevice);
            $storageDevice->addKnownIssue($this);
        }

        return $this;
    }

    public function removeStorageDevice(StorageDevice $storageDevice): self
    {
        if ($this->storageDevices->removeElement($storageDevice)) {
            $storageDevice->removeKnownIssue($this);
        }

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }
    public function getTypeFormatted(): string
    {
        switch($this->type){
            case 1: return "Motherboards";
            case 2: return "Expansion cards";
            case 3: return "Hard drives";
            case 4: return "Optical drives";
            case 5: return "Floppy drives";
            case 6: return "CPUs";
            default: return "";
        }
    }

    public function setType(?int $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param KnownIssueType[] $types
     */
    public function setTypes(array $types): static
    {
        $this->type = array_sum(array_column($types, 'value'));

        return $this;
    }

    /**
     * @return KnownIssueType[]
     */
    public function getTypes(): array
    {
        $result = [];
        foreach (array_column(KnownIssueType::cases(), 'value') as $type) {
            if ($this->type & $type) {
                $result[] = KnownIssueType::from($type);
            }
        }
        return $result;
    }

    /**
     * @return Collection<int, ExpansionCard>
     */
    public function getExpansionCards(): Collection
    {
        return $this->expansionCards;
    }

    public function addExpansionCard(ExpansionCard $expansionCard): static
    {
        if (!$this->expansionCards->contains($expansionCard)) {
            $this->expansionCards->add($expansionCard);
            $expansionCard->addKnownIssue($this);
        }

        return $this;
    }

    public function removeExpansionCard(ExpansionCard $expansionCard): static
    {
        if ($this->expansionCards->removeElement($expansionCard)) {
            $expansionCard->removeKnownIssue($this);
        }

        return $this;
    }
}
