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

    #[ORM\ManyToOne(inversedBy: 'ioPorts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExpansionCard $expansionCard = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardIoPorts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:'I/O port connector cannot be blank')]
    private ?IoPortInterface $ioPortInterface = null;

    #[ORM\ManyToMany(targetEntity: IoPortSignal::class, inversedBy: 'expansionCards')]
    private Collection $ioPortSignals;

    #[Assert\PositiveOrZero(message: "I/O port count should be 0 or above")]
    #[Assert\LessThan(100, message: "I/O port count should be below 100")]
    #[Assert\NotBlank(message:'I/O port count cannot be blank')]
    #[ORM\Column]
    private ?int $count = null;

    #[ORM\Column]
    private ?bool $isInternal = null;

    #[ORM\ManyToOne(inversedBy: 'expansionCardIoPorts')]
    private ?IoPortInterfaceSignal $ioPortInterfaceSignal = null;

    public function __construct()
    {
        $this->ioPortSignals = new ArrayCollection();
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

    public function getIoPortInterface(): ?IoPortInterface
    {
        return $this->ioPortInterface;
    }

    public function setIoPortInterface(?IoPortInterface $ioPortInterface): static
    {
        $this->ioPortInterface = $ioPortInterface;

        return $this;
    }

    /**
     * @return Collection<int, IoPortSignal>
     */
    public function getIoPortSignals(): Collection
    {
        return $this->ioPortSignals;
    }

    public function addIoPortSignal(IoPortSignal $ioPortSignal): static
    {
        if (!$this->ioPortSignals->contains($ioPortSignal)) {
            $this->ioPortSignals->add($ioPortSignal);
        }

        return $this;
    }

    public function removeIoPortSignal(IoPortSignal $ioPortSignal): static
    {
        $this->ioPortSignals->removeElement($ioPortSignal);

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

    public function getIoPortInterfaceSignal(): ?IoPortInterfaceSignal
    {
        return $this->ioPortInterfaceSignal;
    }

    public function setIoPortInterfaceSignal(?IoPortInterfaceSignal $ioPortInterfaceSignal): static
    {
        $this->ioPortInterfaceSignal = $ioPortInterfaceSignal;

        return $this;
    }
}
