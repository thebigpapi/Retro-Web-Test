<?php

namespace App\Entity;

use App\Entity\Traits\DocumentationTrait;
use App\Entity\Traits\ImpreciseDateTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: 'App\Repository\ChipDocumentationRepository')]
class ChipDocumentation
{
    use DocumentationTrait;
    use ImpreciseDateTrait;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping:'chipDoc', fileNameProperty:'file_name')]
    private File|null $manualFile = null;

    #[ORM\ManyToOne(targetEntity: Chip::class, inversedBy: 'documentations')]
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
