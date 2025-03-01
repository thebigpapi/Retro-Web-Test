<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\CreditorRepository')]
class Creditor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Website link is longer than {{ limit }} characters.')]
    private $website;

    #[ORM\OneToMany(targetEntity: MotherboardImage::class, mappedBy: 'creditor')]
    private $motherboardImages;

    #[ORM\OneToMany(targetEntity: ChipImage::class, mappedBy: 'creditor')]
    private $chipImages;

    #[ORM\ManyToOne(targetEntity: License::class, inversedBy: 'creditors')]
    #[ORM\JoinColumn(nullable: true)]
    private $license;

    #[ORM\OneToMany(mappedBy: 'creditor', targetEntity: StorageDeviceImage::class)]
    private Collection $storageDeviceImages;

    #[ORM\OneToMany(mappedBy: 'creditor', targetEntity: EntityImage::class)]
    private Collection $entityImages;

    #[ORM\OneToMany(mappedBy: 'creditor', targetEntity: ExpansionCardImage::class)]
    private Collection $cardImages;


    public function __construct()
    {
        $this->chipImages = new ArrayCollection();
        $this->motherboardImages = new ArrayCollection();
        $this->storageDeviceImages = new ArrayCollection();
        $this->entityImages = new ArrayCollection();
        $this->cardImages = new ArrayCollection();
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
    public function getWebsite(): ?string
    {
        return $this->website;
    }
    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }
    public function getLicense(): ?License
    {
        return $this->license;
    }
    public function setLicense(?License $license): self
    {
        $this->license = $license;

        return $this;
    }
    /**
     * @return Collection|MotherboardImage[]
     */
    public function getMotherboardImages(): Collection
    {
        return $this->motherboardImages;
    }
    public function addMotherboardImage(MotherboardImage $motherboardImage): self
    {
        if (!$this->motherboardImages->contains($motherboardImage)) {
            $this->motherboardImages[] = $motherboardImage;
            $motherboardImage->setCreditor($this);
        }

        return $this;
    }
    public function removeMotherboardImage(MotherboardImage $motherboardImage): self
    {
        if ($this->motherboardImages->contains($motherboardImage)) {
            $this->motherboardImages->removeElement($motherboardImage);
            // set the owning side to null (unless already changed)
            if ($motherboardImage->getCreditor() === $this) {
                $motherboardImage->setCreditor(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|ChipImage[]
     */
    public function getChipImages(): Collection
    {
        return $this->chipImages;
    }
    public function addChipImage(ChipImage $chipImage): self
    {
        if (!$this->chipImages->contains($chipImage)) {
            $this->chipImages[] = $chipImage;
            $chipImage->setCreditor($this);
        }

        return $this;
    }
    public function removeChipImage(ChipImage $chipImage): self
    {
        if ($this->chipImages->contains($chipImage)) {
            $this->chipImages->removeElement($chipImage);
            // set the owning side to null (unless already changed)
            if ($chipImage->getCreditor() === $this) {
                $chipImage->setCreditor(null);
            }
        }

        return $this;
    }
    public function getMoboImg(): int
    {
        return count($this->motherboardImages);
    }
    public function getChipImg(): int
    {
        return count($this->chipImages);
    }

    /**
     * @return Collection<int, StorageDeviceImage>
     */
    public function getStorageDeviceImages(): Collection
    {
        return $this->storageDeviceImages;
    }

    public function addStorageDeviceImage(StorageDeviceImage $storageDeviceImage): self
    {
        if (!$this->storageDeviceImages->contains($storageDeviceImage)) {
            $this->storageDeviceImages->add($storageDeviceImage);
            $storageDeviceImage->setCreditor($this);
        }

        return $this;
    }

    public function removeStorageDeviceImage(StorageDeviceImage $storageDeviceImage): self
    {
        if ($this->storageDeviceImages->removeElement($storageDeviceImage)) {
            // set the owning side to null (unless already changed)
            if ($storageDeviceImage->getCreditor() === $this) {
                $storageDeviceImage->setCreditor(null);
            }
        }

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
            $entityImage->setCreditor($this);
        }

        return $this;
    }

    public function removeEntityImage(EntityImage $entityImage): self
    {
        if ($this->entityImages->removeElement($entityImage)) {
            // set the owning side to null (unless already changed)
            if ($entityImage->getCreditor() === $this) {
                $entityImage->setCreditor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EntityImage>
     */
    public function getCardImages(): Collection
    {
        return $this->cardImages;
    }

    public function addCardImage(ExpansionCardImage $expansionCardImage): self
    {
        if (!$this->cardImages->contains($expansionCardImage)) {
            $this->cardImages->add($expansionCardImage);
            $expansionCardImage->setCreditor($this);
        }

        return $this;
    }

    public function removeCardImage(ExpansionCardImage $expansionCardImage): self
    {
        if ($this->cardImages->removeElement($expansionCardImage)) {
            // set the owning side to null (unless already changed)
            if ($expansionCardImage->getCreditor() === $this) {
                $expansionCardImage->setCreditor(null);
            }
        }

        return $this;
    }
}
