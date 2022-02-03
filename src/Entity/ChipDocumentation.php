<?php

namespace App\Entity;

use App\Entity\Traits\DocumentationTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChipDocumentationRepository")
 * @Vich\Uploadable
 */
class ChipDocumentation
{
    use DocumentationTrait;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="chipDoc", fileNameProperty="file_name")
     * 
     * @var File|null
     */
    private $manualFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chip", inversedBy="manuals")
     */
    private $chip;


    public function getChip(): ?Chip
    {
        return $this->chip;
    }

    public function setChip(?Chip $chip): self
    {
        $this->chip = $chip;

        return $this;
    }
}