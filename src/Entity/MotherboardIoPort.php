<?php

namespace App\Entity;

use App\Repository\MotherboardIoPortRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: MotherboardIoPortRepository::class)]
class MotherboardIoPort
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Motherboard::class, inversedBy: 'motherboardIoPorts')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;

    #[ORM\ManyToOne(targetEntity: IoPort::class, inversedBy: 'motherboardIoPorts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:'I/O port type cannot be blank')]
    private $io_port;

    #[Assert\NotBlank(message:'I/O port count cannot be blank')]
    #[ORM\Column(type: 'integer')]
    private $count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotherboard(): ?Motherboard
    {
        return $this->motherboard;
    }
    public function setMotherboard(?Motherboard $motherboard): self
    {
        $this->motherboard = $motherboard;

        return $this;
    }
    public function getIoPort(): ?IoPort
    {
        return $this->io_port;
    }
    public function setIoPort(?IoPort $io_port): self
    {
        $this->io_port = $io_port;

        return $this;
    }
    public function getCount(): ?int
    {
        return $this->count;
    }
    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }
    #[Assert\Callback]
    public function autosetCountIfEmpty(ExecutionContextInterface $context): void
    {
        if(null === $this->count && null !== $this->io_port) {
            $this->count = 1;
        }
        if($this->count < 1){
            $context->buildViolation('Should be above 0!')
                ->atPath('count')
                ->addViolation();
        }
        if($this->count > 99){
            $context->buildViolation('Should be below 100!')
                ->atPath('count')
                ->addViolation();
        }
    }
}
