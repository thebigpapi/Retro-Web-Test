<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 */
class Language
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Manual", mappedBy="language")
     */
    private $manuals;

    public function __construct()
    {
        $this->manuals = new ArrayCollection();
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
     * @return Collection|Manual[]
     */
    public function getManuals(): Collection
    {
        return $this->manuals;
    }

    public function addManual(Manual $manual): self
    {
        if (!$this->manuals->contains($manual)) {
            $this->manuals[] = $manual;
            $manual->setLanguage($this);
        }

        return $this;
    }

    public function removeManual(Manual $manual): self
    {
        if ($this->manuals->contains($manual)) {
            $this->manuals->removeElement($manual);
            // set the owning side to null (unless already changed)
            if ($manual->getLanguage() === $this) {
                $manual->setLanguage(null);
            }
        }

        return $this;
    }
}
