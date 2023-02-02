<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\IoPortRepository')]
class IoPort
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max:255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\OneToMany(targetEntity: MotherboardIoPort::class, mappedBy: 'io_port', orphanRemoval: true)]
    private $motherboardIoPorts;

    public function __construct()
    {
        $this->motherboardIoPorts = new ArrayCollection();
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
     * @return Collection|MotherboardIoPort[]
     */
    public function getMotherboardIoPorts(): Collection
    {
        return $this->motherboardIoPorts;
    }
    public function addMotherboardIoPort(MotherboardIoPort $motherboardIoPort): self
    {
        if (!$this->motherboardIoPorts->contains($motherboardIoPort)) {
            $this->motherboardIoPorts[] = $motherboardIoPort;
            $motherboardIoPort->setIoPort($this);
        }

        return $this;
    }
    public function removeMotherboardIoPort(MotherboardIoPort $motherboardIoPort): self
    {
        if ($this->motherboardIoPorts->contains($motherboardIoPort)) {
            $this->motherboardIoPorts->removeElement($motherboardIoPort);
            // set the owning side to null (unless already changed)
            if ($motherboardIoPort->getIoPort() === $this) {
                $motherboardIoPort->setIoPort(null);
            }
        }

        return $this;
    }
}
