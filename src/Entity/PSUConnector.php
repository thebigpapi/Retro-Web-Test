<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\PSUConnectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PSUConnectorRepository::class)]
#[ApiResource(
    shortName: '/psu_connector',
    operations: [
        new Get(normalizationContext: ['groups' => ['psu_connector:read']]),
        new GetCollection(normalizationContext: ['groups' => ['psu_connector:read']]),
        new Post(denormalizationContext: ['groups' => ['psu_connector:write']]),
        new Put(denormalizationContext: ['groups' => ['psu_connector:write']]),
        new Delete()
    ]
)]
class PSUConnector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['psu_connector:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    #[Groups(['psu_connector:read', 'psu_connector:write'])]
    private $name;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'psuConnectors')]
    private $motherboards;

    #[ORM\OneToMany(mappedBy: 'psuConnector', targetEntity: EntityDocumentation::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $entityDocumentations;

    #[ORM\Column(length: 4096, nullable: true)]
    #[Groups(['psu_connector:read', 'psu_connector:write'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'psuConnector', targetEntity: EntityImage::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $entityImages;

    #[ORM\ManyToMany(targetEntity: StorageDevice::class, mappedBy: 'powerConnectors')]
    private Collection $storageDevices;

    #[ORM\OneToMany(mappedBy: 'powerConnector', targetEntity: ExpansionCardPowerConnector::class)]
    private Collection $expansionCardPowerConnectors;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->entityDocumentations = new ArrayCollection();
        $this->entityImages = new ArrayCollection();
        $this->storageDevices = new ArrayCollection();
        $this->expansionCardPowerConnectors = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->name;
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
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        $this->motherboards->removeElement($motherboard);

        return $this;
    }

    /**
     * @return Collection<int, EntityDocumentation>
     */
    public function getEntityDocumentations(): Collection
    {
        return $this->entityDocumentations;
    }

    public function addEntityDocumentation(EntityDocumentation $entityDocumentation): self
    {
        if (!$this->entityDocumentations->contains($entityDocumentation)) {
            $this->entityDocumentations->add($entityDocumentation);
            $entityDocumentation->setPsuConnector($this);
        }

        return $this;
    }

    public function removeEntityDocumentation(EntityDocumentation $entityDocumentation): self
    {
        if ($this->entityDocumentations->removeElement($entityDocumentation)) {
            // set the owning side to null (unless already changed)
            if ($entityDocumentation->getPsuConnector() === $this) {
                $entityDocumentation->setPsuConnector(null);
            }
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
     * @return Collection<int, EntityImage>
     */
    public function getEntityImages(): Collection
    {
        return $this->entityImages;
    }

    public function addEntityImage(EntityImage $entityImage): self
    {
        if (!$this->entityImages->contains($entityImage)) {
            $this->entityImages->add($entityImage);
            $entityImage->setPsuConnector($this);
        }

        return $this;
    }

    public function removeEntityImage(EntityImage $entityImage): self
    {
        if ($this->entityImages->removeElement($entityImage)) {
            // set the owning side to null (unless already changed)
            if ($entityImage->getPsuConnector() === $this) {
                $entityImage->setPsuConnector(null);
            }
        }

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
            $storageDevice->addPowerConnector($this);
        }

        return $this;
    }

    public function removeStorageDevice(StorageDevice $storageDevice): self
    {
        if ($this->storageDevices->removeElement($storageDevice)) {
            $storageDevice->removePowerConnector($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ExpansionCardPowerConnector>
     */
    public function getExpansionCardPowerConnectors(): Collection
    {
        return $this->expansionCardPowerConnectors;
    }

    public function addExpansionCardPowerConnector(ExpansionCardPowerConnector $expansionCardPowerConnector): static
    {
        if (!$this->expansionCardPowerConnectors->contains($expansionCardPowerConnector)) {
            $this->expansionCardPowerConnectors->add($expansionCardPowerConnector);
            $expansionCardPowerConnector->setPowerConnector($this);
        }

        return $this;
    }

    public function removeExpansionCardPowerConnector(ExpansionCardPowerConnector $expansionCardPowerConnector): static
    {
        if ($this->expansionCardPowerConnectors->removeElement($expansionCardPowerConnector)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardPowerConnector->getPowerConnector() === $this) {
                $expansionCardPowerConnector->setPowerConnector(null);
            }
        }

        return $this;
    }
}