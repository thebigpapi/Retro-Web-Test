<?php

namespace App\Entity;

use App\Entity\Traits\DocumentationTrait;
use App\Entity\Traits\ImpreciseDateTrait;
use App\Repository\StorageDeviceDocumentationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: StorageDeviceDocumentationRepository::class)]
class StorageDeviceDocumentation
{
    use DocumentationTrait;
    use ImpreciseDateTrait;

    #[Vich\UploadableField(mapping:'storageDoc', fileNameProperty:'file_name')]
    private File|null $manualFile = null;

    #[ORM\ManyToOne(targetEntity: StorageDevice::class, inversedBy: 'storageDeviceDocumentations')]
    private $storageDevice;

    public function getStorageDevice(): ?StorageDevice
    {
        return $this->storageDevice;
    }

    public function setStorageDevice(?StorageDevice $storageDevice): self
    {
        $this->storageDevice = $storageDevice;

        return $this;
    }
}
