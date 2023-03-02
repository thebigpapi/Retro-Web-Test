<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LicenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LicenseRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'read:License:item'],
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:License:list']], 
        'post' => ['denormalization_context' => ['groups' => 'write:License']]
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:License:item']],
        'put' => ['denormalization_context' => ['groups' => 'write:License']],
        'delete'
    ],
    order: ['name' => 'ASC'],
    paginationEnabled: false,
)]
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
