<?php

namespace App\Entity\Traits;

use App\Entity\Language;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManualRepository")
 * @Vich\Uploadable
 */
trait DocumentationTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $file_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $link_name;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Language', inversedBy: 'manuals')]
    #[ORM\JoinColumn(nullable: false)]
    private $language;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->file_name;
    }

    public function setFileName(?string $file_name): self
    {
        $this->file_name = $file_name;

        return $this;
    }

    public function getLinkName(): ?string
    {
        return $this->link_name;
    }

    public function setLinkName(string $link_name): self
    {
        $this->link_name = $link_name;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getManualFile(): ?File
    {
        return $this->manualFile;
    }
    public function setManualFile(?File $manualFile): self
    {
        $this->manualFile = $manualFile;
        if ($this->manualFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
