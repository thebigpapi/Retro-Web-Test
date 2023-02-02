<?php

namespace App\Entity;

use App\Entity\Traits\DocumentationTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: 'App\Repository\ChipsetDocumentationRepository')]
class ChipsetDocumentation
{
    use DocumentationTrait;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping:'chipsetDoc', fileNameProperty:'file_name')]
    private File|null $manualFile;

    #[ORM\ManyToOne(targetEntity: Chipset::class, inversedBy: 'documentations')]
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
