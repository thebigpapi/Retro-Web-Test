<?php

namespace App\Entity;

use App\Entity\Traits\DocumentationTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManualRepository")
 * @Vich\Uploadable
 */
class Manual
{
    use DocumentationTrait;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="manual", fileNameProperty="file_name")
     * 
     * @var File|null
     */
    private $manualFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Motherboard", inversedBy="manuals")
     */
    private $motherboard;


    public function getMotherboard(): ?Motherboard
    {
        return $this->motherboard;
    }

    public function setMotherboard(?Motherboard $motherboard): self
    {
        $this->motherboard = $motherboard;

        return $this;
    }
}
