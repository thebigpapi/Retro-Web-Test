<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\MotherboardIoPortRepository')]
class MotherboardIoPort
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Motherboard', inversedBy: 'motherboardIoPorts')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;
    
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: 'App\Entity\IoPort', inversedBy: 'motherboardIoPorts')]
    #[ORM\JoinColumn(nullable: false)]
    private $io_port;

    #[ORM\Column(type: 'integer')]
    private $count;

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
