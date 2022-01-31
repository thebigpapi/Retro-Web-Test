<?php

namespace App\Entity;

use App\Entity\Traits\DocumentationTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChipsetDocumentationRepository")
 * @Vich\Uploadable
 */
class ChipsetDocumentation
{
    use DocumentationTrait;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="chipsetDoc", fileNameProperty="file_name")
     * 
     * @var File|null
     */
    private $manualFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chipset", inversedBy="manuals")
     */
    private $chipset;


    public function getChipset(): ?Chipset
    {
        return $this->chipset;
    }

    public function setChipset(?Chipset $chipset): self
    {
        $this->chipset = $chipset;

        return $this;
    }
}
