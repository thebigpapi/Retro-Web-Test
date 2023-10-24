<?php

namespace App\Entity;

use App\Repository\PSUConnectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PSUConnectorRepository::class)]
class PSUConnector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'psuConnectors')]
    private $motherboards;

    #[ORM\OneToMany(mappedBy: 'psuConnector', targetEntity: EntityDocumentation::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $entityDocumentations;

    #[ORM\Column(length: 4096, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'psuConnector', targetEntity: EntityImage::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $entityImages;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->entityDocumentations = new ArrayCollection();
        $this->entityImages = new ArrayCollection();
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
}
