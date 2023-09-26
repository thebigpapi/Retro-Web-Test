<?php

namespace App\Entity;

use App\Repository\StorageDeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StorageDeviceRepository::class)]
#[ORM\InheritanceType('JOINED')]
class StorageDevice
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

    #[ORM\Column(length: 4096, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: KnownIssue::class, inversedBy: 'storageDevices')]
    private $knownIssues;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'storageDevices', fetch: 'EAGER')]
    protected $manufacturer;

    #[ORM\OneToMany(mappedBy: 'storageDevice', targetEntity: AudioFile::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $audioFiles;

    #[ORM\OneToMany(mappedBy: 'storageDevice', targetEntity: StorageDeviceDocumentation::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $storageDeviceDocumentations;

    #[ORM\OneToMany(mappedBy: 'storageDevice', targetEntity: StorageDeviceImage::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $storageDeviceImages;

    #[ORM\ManyToOne(targetEntity: StorageDeviceInterface::class, inversedBy: 'storageDevices')]
    private $interface = null;

    #[ORM\ManyToOne(targetEntity: StorageDeviceSize::class, inversedBy: 'storageDevices')]
    private $physicalSize = null;

    #[ORM\OneToMany(mappedBy: 'storageDevice', targetEntity: StorageDeviceAlias::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $storageDeviceAliases;

    #[ORM\Column(type: 'datetime')]
    private $lastEdited;

    public function __construct()
    {
        $this->knownIssues = new ArrayCollection();
        $this->audioFiles = new ArrayCollection();
        $this->storageDeviceDocumentations = new ArrayCollection();
        $this->storageDeviceImages = new ArrayCollection();
        $this->storageDeviceAliases = new ArrayCollection();
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
     * @return Collection<int, KnownIssue>
     */
    public function getKnownIssues(): Collection
    {
        return $this->knownIssues;
    }

    public function addKnownIssue(KnownIssue $knownIssue): self
    {
        if (!$this->knownIssues->contains($knownIssue)) {
            $this->knownIssues->add($knownIssue);
        }

        return $this;
    }

    public function removeKnownIssue(KnownIssue $knownIssue): self
    {
        $this->knownIssues->removeElement($knownIssue);

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
     * @return Collection<int, AudioFile>
     */
    public function getAudioFiles(): Collection
    {
        return $this->audioFiles;
    }

    public function addAudioFile(AudioFile $audioFile): self
    {
        if (!$this->audioFiles->contains($audioFile)) {
            $this->audioFiles->add($audioFile);
            $audioFile->setStorageDevice($this);
        }

        return $this;
    }

    public function removeAudioFile(AudioFile $audioFile): self
    {
        if ($this->audioFiles->removeElement($audioFile)) {
            // set the owning side to null (unless already changed)
            if ($audioFile->getStorageDevice() === $this) {
                $audioFile->setStorageDevice(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StorageDeviceDocumentation>
     */
    public function getStorageDeviceDocumentations(): Collection
    {
        return $this->storageDeviceDocumentations;
    }

    public function addStorageDeviceDocumentation(StorageDeviceDocumentation $storageDeviceDocumentation): self
    {
        if (!$this->storageDeviceDocumentations->contains($storageDeviceDocumentation)) {
            $this->storageDeviceDocumentations->add($storageDeviceDocumentation);
            $storageDeviceDocumentation->setStorageDevice($this);
        }

        return $this;
    }

    public function removeStorageDeviceDocumentation(StorageDeviceDocumentation $storageDeviceDocumentation): self
    {
        if ($this->storageDeviceDocumentations->removeElement($storageDeviceDocumentation)) {
            // set the owning side to null (unless already changed)
            if ($storageDeviceDocumentation->getStorageDevice() === $this) {
                $storageDeviceDocumentation->setStorageDevice(null);
            }
        }

        return $this;
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
            $storageDeviceImage->setStorageDevice($this);
        }

        return $this;
    }

    public function removeStorageDeviceImage(StorageDeviceImage $storageDeviceImage): self
    {
        if ($this->storageDeviceImages->removeElement($storageDeviceImage)) {
            // set the owning side to null (unless already changed)
            if ($storageDeviceImage->getStorageDevice() === $this) {
                $storageDeviceImage->setStorageDevice(null);
            }
        }

        return $this;
    }

    public function getInterface(): ?StorageDeviceInterface
    {
        return $this->interface;
    }

    public function setInterface(?StorageDeviceInterface $interface): self
    {
        $this->interface = $interface;

        return $this;
    }

    public function getPhysicalSize(): ?StorageDeviceSize
    {
        return $this->physicalSize;
    }

    public function setPhysicalSize(?StorageDeviceSize $physicalSize): self
    {
        $this->physicalSize = $physicalSize;

        return $this;
    }

    /**
     * @return Collection<int, StorageDeviceAlias>
     */
    public function getStorageDeviceAliases(): Collection
    {
        return $this->storageDeviceAliases;
    }

    public function addStorageDeviceAlias(StorageDeviceAlias $storageDeviceAlias): self
    {
        if (!$this->storageDeviceAliases->contains($storageDeviceAlias)) {
            $this->storageDeviceAliases->add($storageDeviceAlias);
            $storageDeviceAlias->setStorageDevice($this);
        }

        return $this;
    }

    public function removeStorageDeviceAlias(StorageDeviceAlias $storageDeviceAlias): self
    {
        if ($this->storageDeviceAliases->removeElement($storageDeviceAlias)) {
            // set the owning side to null (unless already changed)
            if ($storageDeviceAlias->getStorageDevice() === $this) {
                $storageDeviceAlias->setStorageDevice(null);
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
    public function getNameWithManufacturer()
    {
        $result = $this->manufacturer ? $this->getManufacturer()->getName() : "Unidentified";
        $result .= " " . $this->partNumber;
        $result .= $this->name ? " (" . $this->name . ")" : "";
        return $result;
    }
}
