<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PSUConnectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PSUConnectorRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'read:PSUConnector:item'],
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:PSUConnector:list']], 
        'post' => ['denormalization_context' => ['groups' => 'write:PSUConnector']]
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:PSUConnector:item']],
        'put' => ['denormalization_context' => ['groups' => 'write:PSUConnector']],
        'delete'
    ],
    order: ['name' => 'ASC'],
    paginationEnabled: false,
    shortName:'PowerConnectors'
)]
class PSUConnector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:PSUConnector:list', 'read:PSUConnector:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    #[Groups(['read:PSUConnector:list', 'read:PSUConnector:item', 'write:PSUConnector'])]
    private $name;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'psuConnectors')]
    private $motherboards;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Website link is longer than {{ limit }} characters, try to make it shorter.')]
    #[Groups(['read:PSUConnector:item', 'write:PSUConnector'])]
    private ?string $website = null;

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
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
     * @return Collection|Motherboard[]
     */
    public function getMotherboards(): Collection
    {
        return $this->motherboards;
    }
    public function addMotherboard(Motherboard $motherboard): self
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        $this->motherboards->removeElement($motherboard);

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
