<?php

namespace App\Entity;

use App\Repository\CpuSocketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CpuSocketRepository::class)]
class CpuSocket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    private $name;

    #[ORM\ManyToMany(targetEntity: ProcessorPlatformType::class, inversedBy: 'cpuSockets')]
    private $platforms;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'cpuSockets')]
    private $motherboards;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Type is longer than {{ limit }} characters.')]
    private $type;

    #[ORM\ManyToMany(targetEntity: Chip::class, mappedBy: 'sockets')]
    private $chips;

    #[ORM\OneToMany(mappedBy: 'cpuSocket', targetEntity: EntityDocumentation::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $entityDocumentations;

    #[ORM\Column(length: 4096, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'cpuSocket', targetEntity: EntityImage::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $entityImages;

    public function __construct()
    {
        $this->platforms = new ArrayCollection();
        $this->motherboards = new ArrayCollection();
        $this->chips = new ArrayCollection();
        $this->entityDocumentations = new ArrayCollection();
        $this->entityImages = new ArrayCollection();
    }
    public function __toString(): string
    {
        if(!$this->name)
            return $this->type;
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
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return Collection|ProcessorPlatformType[]
     */
    public function getPlatforms(): Collection
    {
        return $this->platforms;
    }
    public function addPlatform(ProcessorPlatformType $platform): self
    {
        if (!$this->platforms->contains($platform)) {
            $this->platforms[] = $platform;
        }

        return $this;
    }
    public function removePlatform(ProcessorPlatformType $platform): self
    {
        if ($this->platforms->contains($platform)) {
            $this->platforms->removeElement($platform);
        }

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
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
        }

        return $this;
    }
    public function getType(): ?string
    {
        return $this->type;
    }
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getNameAndType(): ?string
    {
        if ($this->name) {
            return "$this->name ($this->type)";
        } else {
            return $this->type;
        }
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
            $chip->addSocket($this);
        }

        return $this;
    }
    public function removeChip(Chip $chip): self
    {
        if ($this->chips->contains($chip)) {
            $this->chips->removeElement($chip);
            $chip->removeSocket($this);
        }

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
            $entityDocumentation->setCpuSocket($this);
        }

        return $this;
    }

    public function removeEntityDocumentation(EntityDocumentation $entityDocumentation): self
    {
        if ($this->entityDocumentations->removeElement($entityDocumentation)) {
            // set the owning side to null (unless already changed)
            if ($entityDocumentation->getCpuSocket() === $this) {
                $entityDocumentation->setCpuSocket(null);
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
            $entityImage->setCpuSocket($this);
        }

        return $this;
    }

    public function removeEntityImage(EntityImage $entityImage): self
    {
        if ($this->entityImages->removeElement($entityImage)) {
            // set the owning side to null (unless already changed)
            if ($entityImage->getCpuSocket() === $this) {
                $entityImage->setCpuSocket(null);
            }
        }

        return $this;
    }
}
