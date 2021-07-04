<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MotherboardIdRedirectionRepository")
 */
class MotherboardIdRedirection extends IdRedirection
{

    /**
     * @ORM\ManyToOne(targetEntity=Motherboard::class, inversedBy="redirections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destination;

    public function __construct()
    {
        parent::__construct();
    }

    public function getDestination(): ?Motherboard
    {
        return $this->destination;
    }

    public function setDestination(?Motherboard $destination): self
    {
        $this->destination = $destination;

        return $this;
    }
}
