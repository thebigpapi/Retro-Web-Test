<?php

namespace App\Entity;

use App\Repository\OsFlagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OsFlagRepository::class)
 */
class OsFlag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $majorVersion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minorVersion;

    /**
     * @ORM\ManyToOne(targetEntity=Manufacturer::class, inversedBy="osFlags")
     * @ORM\JoinColumn(nullable=true)
     */
    private $manufacturer;

    /**
     * @ORM\ManyToMany(targetEntity=OsFamily::class, inversedBy="osFlags")
     */
    private $osFamilies;

    public function __construct()
    {
        $this->osFamilies = new ArrayCollection();
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

    public function getMajorVersion(): ?string
    {
        return $this->majorVersion;
    }

    public function setMajorVersion(string $majorVersion): self
    {
        $this->majorVersion = $majorVersion;

        return $this;
    }

    public function getMinorVersion(): ?string
    {
        return $this->minorVersion;
    }

    public function setMinorVersion(?string $minorVersion): self
    {
        $this->minorVersion = $minorVersion;

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


    public function addFamily(?OsFamily $family): self
    {
        $this->family = $family;

        return $this;
    }

    /**
     * @return Collection|OsFamily[]
     */
    public function getOsFamilies(): Collection
    {
        return $this->osFamilies;
    }

    public function addOsFamily(OsFamily $osFamily): self
    {
        if (!$this->osFamilies->contains($osFamily)) {
            $this->osFamilies[] = $osFamily;
        }

        return $this;
    }

    public function removeOsFamily(OsFamily $osFamily): self
    {
        $this->osFamilies->removeElement($osFamily);

        return $this;
    }

}
