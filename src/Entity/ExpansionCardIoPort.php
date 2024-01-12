<?php

namespace App\Entity;

use App\Repository\ExpansionCardIoPortRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpansionCardIoPortRepository::class)]
class ExpansionCardIoPort
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardIoPorts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExpansionCard $expansionCard = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardIoPorts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:'I/O port connector cannot be blank')]
    private ?IoPortInterface $ioPort = null;

    #[ORM\ManyToMany(targetEntity: IoPortType::class, inversedBy: 'expansionCards')]
    private Collection $ioPortTypes;

    #[Assert\PositiveOrZero(message: "I/O port count should be 0 or above")]
    #[Assert\LessThan(100, message: "I/O port count should be below 100")]
    #[Assert\NotBlank(message:'I/O port count cannot be blank')]
    #[ORM\Column]
    private ?int $count = null;

    #[ORM\Column]
    private ?bool $isInternal = null;

    public function __construct()
    {
        $this->ioPortTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpansionCard(): ?ExpansionCard
    {
        return $this->expansionCard;
    }

    public function setExpansionCard(?ExpansionCard $expansionCard): static
    {
        $this->expansionCard = $expansionCard;

        return $this;
    }

    public function getIoPort(): ?IoPortInterface
    {
        return $this->ioPort;
    }

    public function setIoPort(?IoPortInterface $ioPort): static
    {
        $this->ioPort = $ioPort;

        return $this;
    }

    /**
     * @return Collection<int, IoPortType>
     */
    public function getIoPortTypes(): Collection
    {
        return $this->ioPortTypes;
    }

    public function addIoPortType(IoPortType $ioPortType): static
    {
        if (!$this->ioPortTypes->contains($ioPortType)) {
            $this->ioPortTypes->add($ioPortType);
        }

        return $this;
    }

    public function removeIoPortType(IoPortType $ioPortType): static
    {
        $this->ioPortTypes->removeElement($ioPortType);

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): static
    {
        $this->count = $count;

        return $this;
    }

    public function isIsInternal(): ?bool
    {
        return $this->isInternal;
    }

    public function setIsInternal(bool $isInternal): static
    {
        $this->isInternal = $isInternal;

        return $this;
    }
}
