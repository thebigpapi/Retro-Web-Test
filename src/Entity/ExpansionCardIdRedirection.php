<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\ExpansionCardIdRedirectionRepository')]
class ExpansionCardIdRedirection extends IdRedirection
{
    #[ORM\ManyToOne(targetEntity: ExpansionCard::class, inversedBy: 'redirections')]
    #[ORM\JoinColumn(nullable: false)]
    private $destination;

    public function __construct()
    {
        parent::__construct();
    }
    public function getDestination(): ?ExpansionCard
    {
        return $this->destination;
    }
    public function setDestination(?ExpansionCard $destination): self
    {
        $this->destination = $destination;

        return $this;
    }
}
