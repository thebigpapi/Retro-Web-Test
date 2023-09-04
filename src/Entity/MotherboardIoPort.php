<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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

    #[Assert\Positive(message: "I/O port count should be above 0")]
    #[Assert\LessThan(100, message: "I/O port count should be below 100")]
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
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
