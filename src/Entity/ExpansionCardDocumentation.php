<?php

namespace App\Entity;

use App\Entity\Traits\DocumentationTrait;
use App\Entity\Traits\ImpreciseDateTrait;
use App\Repository\ExpansionCardDocumentationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ExpansionCardDocumentationRepository::class)]
class ExpansionCardDocumentation
{
    use DocumentationTrait;
    use ImpreciseDateTrait;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping:'cardDoc', fileNameProperty:'file_name')]
    private File|null $manualFile = null;

    #[ORM\ManyToOne(targetEntity: ExpansionCard::class, inversedBy: 'documentations')]
    private ?ExpansionCard $expansionCard = null;

    public function getExpansionCard(): ?ExpansionCard
    {
        return $this->expansionCard;
    }

    public function setExpansionCard(?ExpansionCard $expansionCard): static
    {
        $this->expansionCard = $expansionCard;

        return $this;
    }
}
