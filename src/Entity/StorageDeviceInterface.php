<?php

namespace App\Entity;

use App\Repository\StorageDeviceInterfaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StorageDeviceInterfaceRepository::class)]
class StorageDeviceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\OneToMany(mappedBy: 'interface', targetEntity: StorageDevice::class)]
    private $storageDevices;

    public function __construct()
    {
        $this->storageDevices = new ArrayCollection();
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
            $storageDevice->setInterface($this);
        }

        return $this;
    }

    public function removeStorageDevice(StorageDevice $storageDevice): self
    {
        if ($this->storageDevices->removeElement($storageDevice)) {
            // set the owning side to null (unless already changed)
            if ($storageDevice->getInterface() === $this) {
                $storageDevice->setInterface(null);
            }
        }

        return $this;
    }
}
