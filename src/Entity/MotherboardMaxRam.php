<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MotherboardMaxRamRepository")
 */
class MotherboardMaxRam
{

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Motherboard", inversedBy="motherboardMaxRams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $motherboard;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\MaxRam", inversedBy="motherboardMaxRams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $max_ram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;

    public function getMotherboard(): ?Motherboard
    {
        return $this->motherboard;
    }

    public function setMotherboard(?Motherboard $motherboard): self
    {
        $this->motherboard = $motherboard;

        return $this;
    }

    public function getMaxram(): ?MaxRam
    {
        return $this->max_ram;
    }

    public function setMaxram(?MaxRam $max_ram): self
    {
        $this->max_ram = $max_ram;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
