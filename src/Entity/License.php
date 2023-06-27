<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\LicenseRepository;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[
    ApiResource(
        operations: [
            new Get(normalizationContext: ['groups' => 'read:License:item']),
            new Put(denormalizationContext: ['groups' => 'write:License']),
            new Delete(),
            new GetCollection(normalizationContext: ['groups' => 'read:License:list']),
            new Post(denormalizationContext: ['groups' => 'write:License'])
        ],
        normalizationContext: ['groups' => 'read:License:item'],
        order: ['name' => 'ASC'],
        paginationEnabled: false
    )
]
#[ORM\Entity(repositoryClass: LicenseRepository::class)]
class License
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:License:list', 'read:License:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    #[Groups(['read:License:list', 'read:License:item', 'write:License'])]
    private $name;

    #[ORM\OneToMany(targetEntity: Creditor::class, mappedBy: 'license')]
    private $creditors;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Website is longer than {{ limit }} characters, try to make it shorter.')]
    private ?string $website = null;

    public function __construct()
    {
        $this->motherboardImages = new ArrayCollection();
        $this->chipImages = new ArrayCollection();
        $this->creditors = new ArrayCollection();
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
     * @return Collection|Creditor[]
     */
    public function getCreditors(): Collection
    {
        return $this->creditors;
    }
    public function addCreditor(Creditor $creditor): self
    {
        if (!$this->creditors->contains($creditor)) {
            $this->creditors[] = $creditor;
            $creditor->setLicense($this);
        }

        return $this;
    }
    public function removeCreditor(Creditor $creditor): self
    {
        if ($this->creditors->contains($creditor)) {
            $this->creditors->removeElement($creditor);
            // set the owning side to null (unless already changed)
            if ($creditor->getLicense() === $this) {
                $creditor->setLicense(null);
            }
        }

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
}
