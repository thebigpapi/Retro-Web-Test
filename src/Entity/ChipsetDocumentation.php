<?php

namespace App\Entity;

use App\Entity\Traits\DocumentationTrait;
use App\Entity\Traits\ImpreciseDateTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: 'App\Repository\ChipsetDocumentationRepository')]
class ChipsetDocumentation
{
    use DocumentationTrait;
    use ImpreciseDateTrait;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping:'chipsetDoc', fileNameProperty:'file_name')]
    private File|null $manualFile = null;

    #[ORM\ManyToOne(targetEntity: Chipset::class, inversedBy: 'documentations')]
    private $chipset;
    public function __toString(): string
    {
        return $this->getLinkName() . " [" . $this->getReleaseDateString() . "]";
    }
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
