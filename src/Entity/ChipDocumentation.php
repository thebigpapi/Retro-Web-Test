<?php

namespace App\Entity;

use App\Entity\Traits\DocumentationTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: 'App\Repository\ChipDocumentationRepository')]
class ChipDocumentation
{
    use DocumentationTrait;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping:'chipDoc', fileNameProperty:'file_name')]
    private File|null $manualFile;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Chip', inversedBy: 'documentations')]
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
