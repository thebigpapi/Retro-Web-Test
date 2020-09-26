<?php

namespace App\Entity;

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
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="manual", fileNameProperty="file_name")
     * 
     * @var File|null
     */
    private $manualFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $file_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Motherboard", inversedBy="manuals")
     */
    private $motherboard;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="manuals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\Column(type="datetime")
     */
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

    public function getMotherboard(): ?Motherboard
    {
        return $this->motherboard;
    }

    public function setMotherboard(?Motherboard $motherboard): self
    {
        $this->motherboard = $motherboard;

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
