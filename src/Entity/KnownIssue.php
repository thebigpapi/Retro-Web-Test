<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KnownIssueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: KnownIssueRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'read:KnownIssue:item'],
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:KnownIssue:list']], 
        'post' => ['denormalization_context' => ['groups' => 'write:KnownIssue']]
    ],
    itemOperations: [
        'get' => ['normalization_context' => ['groups' => 'read:KnownIssue:item']],
        'put' => ['denormalization_context' => ['groups' => 'write:KnownIssue']],
        'delete'
    ],
    order: ['name' => 'ASC'],
    paginationEnabled: false,
)]
class KnownIssue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:KnownIssue:list', 'read:KnownIssue:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters, try to make it shorter.')]
    #[Groups(['read:KnownIssue:list', 'read:KnownIssue:item', 'write:KnownIssue'])]
    private $name;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'knownIssues')]
    private $motherboards;

    #[ORM\Column(type: 'string', length: 512, nullable: true)]
    #[Assert\Length(max: 512, maxMessage: 'Description is longer than {{ limit }} characters, try to make it shorter.')]
    #[Groups(['read:KnownIssue:item', 'write:KnownIssue'])]
    private $description;

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
            $motherboard->addKnownIssue($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            $this->motherboards->removeElement($motherboard);
            $motherboard->removeKnownIssue($this);
        }

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
}
