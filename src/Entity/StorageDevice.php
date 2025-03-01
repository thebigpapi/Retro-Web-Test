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
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    protected $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Part number is longer than {{ limit }} characters.')]
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

    #[ORM\OneToMany(targetEntity: StorageDeviceIdRedirection::class, mappedBy: 'destination', orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $redirections;

    #[ORM\ManyToOne(targetEntity: StorageDeviceSize::class, inversedBy: 'storageDevices')]
    private $physicalSize = null;

    #[ORM\OneToMany(mappedBy: 'storageDevice', targetEntity: StorageDeviceAlias::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private $storageDeviceAliases;

    #[ORM\Column(type: 'datetime')]
    private $lastEdited;

    #[ORM\ManyToMany(targetEntity: StorageDeviceInterface::class, inversedBy: 'storageDevices')]
    private Collection $interfaces;

    #[ORM\ManyToMany(targetEntity: PSUConnector::class, inversedBy: 'storageDevices')]
    private Collection $powerConnectors;

    #[ORM\OneToMany(mappedBy: 'storageDevice', targetEntity: StorageDeviceMiscFile::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $storageDeviceMiscFiles;

    public function __construct()
    {
        $this->knownIssues = new ArrayCollection();
        $this->audioFiles = new ArrayCollection();
        $this->storageDeviceDocumentations = new ArrayCollection();
        $this->storageDeviceImages = new ArrayCollection();
        $this->storageDeviceAliases = new ArrayCollection();
        $this->redirections = new ArrayCollection();
        $this->lastEdited = new \DateTime('now');
        $this->interfaces = new ArrayCollection();
        $this->powerConnectors = new ArrayCollection();
        $this->storageDeviceMiscFiles = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getFullName();
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
    public function isStorageDeviceImage(): string
    {
        if(isset($this->storageDeviceImages))
            $types = array(
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
            );
        foreach($this->storageDeviceImages as $image){
            $types[(int)$image->getType()] += 1;
        }
        if(($types[1])){
            if(!($types[2] || $types[3] || $types[4] || $types[5] || $types[6]))
                return "Schema only";
            else return "Schema and photo";
        }
        else{
            if(!($types[2] || $types[3] || $types[4] || $types[5] || $types[6]))
                return "None";
            else return "Photo only";
        }
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
    public function addAlias(Manufacturer $manuf, ?string $name, string $partNumber): self
    {
        $sa = new StorageDeviceAlias();
        $sa->setManufacturer($manuf);
        $sa->setStorageDevice($this);
        $sa->setName($name);
        $sa->setPartNumber($partNumber);

        return $this->addStorageDeviceAlias($sa);
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

    /**
     * @return Collection|MotherboardIdRedirection[]
     */
    public function getRedirections(): Collection
    {
        return $this->redirections;
    }
    public function addRedirection(StorageDeviceIdRedirection $redirection): self
    {
        if (!$this->redirections->contains($redirection)) {
            $this->redirections[] = $redirection;
            $redirection->setDestination($this);
        }

        return $this;
    }
    public function removeRedirection(StorageDeviceIdRedirection $redirection): self
    {
        if ($this->redirections->removeElement($redirection)) {
            // set the owning side to null (unless already changed)
            if ($redirection->getDestination() === $this) {
                $redirection->setDestination(null);
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
    public function getFullName()
    {
        $result = $this->manufacturer ? $this->getManufacturer()->getName() : "Unidentified";
        $result .= " " . $this->partNumber;
        $result .= $this->name ? " (" . $this->name . ")" : "";
        return $result;
    }
    public function getNameWithoutManuf(): string
    {
        if ($this->name) {
            return $this->partNumber . " (" . $this->name . ")";
        }
        return $this->partNumber;
    }

    /**
     * @return Collection<int, StorageDeviceInterface>
     */
    public function getInterfaces(): Collection
    {
        return $this->interfaces;
    }

    public function addInterface(StorageDeviceInterface $interface): self
    {
        if (!$this->interfaces->contains($interface)) {
            $this->interfaces->add($interface);
        }

        return $this;
    }

    public function removeInterface(StorageDeviceInterface $interface): self
    {
        $this->interfaces->removeElement($interface);

        return $this;
    }

    /**
     * @return Collection<int, PSUConnector>
     */
    public function getPowerConnectors(): Collection
    {
        return $this->powerConnectors;
    }

    public function addPowerConnector(PSUConnector $powerConnector): self
    {
        if (!$this->powerConnectors->contains($powerConnector)) {
            $this->powerConnectors->add($powerConnector);
        }

        return $this;
    }

    public function removePowerConnector(PSUConnector $powerConnector): self
    {
        $this->powerConnectors->removeElement($powerConnector);

        return $this;
    }

    /**
     * @return Collection<int, StorageDeviceMiscFile>
     */
    public function getStorageDeviceMiscFiles(): Collection
    {
        return $this->storageDeviceMiscFiles;
    }

    public function addStorageDeviceMiscFile(StorageDeviceMiscFile $storageDeviceMiscFile): static
    {
        if (!$this->storageDeviceMiscFiles->contains($storageDeviceMiscFile)) {
            $this->storageDeviceMiscFiles->add($storageDeviceMiscFile);
            $storageDeviceMiscFile->setStorageDevice($this);
        }

        return $this;
    }

    public function removeStorageDeviceMiscFile(StorageDeviceMiscFile $storageDeviceMiscFile): static
    {
        if ($this->storageDeviceMiscFiles->removeElement($storageDeviceMiscFile)) {
            // set the owning side to null (unless already changed)
            if ($storageDeviceMiscFile->getStorageDevice() === $this) {
                $storageDeviceMiscFile->setStorageDevice(null);
            }
        }

        return $this;
    }
}
