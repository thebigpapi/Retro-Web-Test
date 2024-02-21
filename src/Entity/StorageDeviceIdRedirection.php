<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\StorageDeviceIdRedirectionRepository')]
class StorageDeviceIdRedirection extends IdRedirection
{
    #[ORM\ManyToOne(targetEntity: StorageDevice::class, inversedBy: 'redirections')]
    #[ORM\JoinColumn(nullable: false)]
    private $destination;
    public function __construct()
    {
        parent::__construct();
    }
    public function getDestination(): ?StorageDevice
    {
        return $this->destination;
    }
    public function setDestination(?StorageDevice $destination): self
    {
        $this->destination = $destination;

        return $this;
    }
}
