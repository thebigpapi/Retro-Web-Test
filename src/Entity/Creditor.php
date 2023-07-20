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
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Website link is longer than {{ limit }} characters, try to make it shorter.')]
    private $website;

    #[ORM\OneToMany(targetEntity: MotherboardImage::class, mappedBy: 'creditor')]
    private $motherboardImages;

    #[ORM\OneToMany(targetEntity: ChipImage::class, mappedBy: 'creditor')]
    private $chipImages;

    #[ORM\ManyToOne(targetEntity: License::class, inversedBy: 'creditors')]
    #[ORM\JoinColumn(nullable: true)]
    private $license;

    public function __construct()
    {
        $this->chipImages = new ArrayCollection();
        $this->motherboardImages = new ArrayCollection();
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
}
