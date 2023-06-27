<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\MotherboardImageTypeRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'read:MotherboardImageType:item']),
        new Put(denormalizationContext: ['groups' => 'write:MotherboardImageType']),
        new Delete(),
        new GetCollection(normalizationContext: ['groups' => 'read:MotherboardImageType:list']),
        new Post(denormalizationContext: ['groups' => 'write:MotherboardImageType'])
    ],
    normalizationContext: ['groups' => 'read:MotherboardImageType:item'],
    order: ['name' => 'ASC'],
    paginationEnabled: false
)]
#[ORM\Entity(repositoryClass: MotherboardImageTypeRepository::class)]
class MotherboardImageType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:MotherboardImageType:list', 'read:MotherboardImageType:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    #[Groups(['read:MotherboardImageType:list', 'read:MotherboardImageType:item', 'write:MotherboardImageType'])]
    private $name;

    #[ORM\OneToMany(targetEntity: MotherboardImage::class, mappedBy: 'motherboardImageType')]
    private $motherboardImages;

    public function __construct()
    {
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
            $motherboardImage->setMotherboardImageType($this);
        }

        return $this;
    }
    public function removeMotherboardImage(MotherboardImage $motherboardImage): self
    {
        if ($this->motherboardImages->contains($motherboardImage)) {
            $this->motherboardImages->removeElement($motherboardImage);
            // set the owning side to null (unless already changed)
            if ($motherboardImage->getMotherboardImageType() === $this) {
                $motherboardImage->setMotherboardImageType(null);
            }
        }

        return $this;
    }
}
