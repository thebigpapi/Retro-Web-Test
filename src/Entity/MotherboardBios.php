<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: 'App\Repository\MotherboardBiosRepository')]
class MotherboardBios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Motherboard::class, inversedBy: 'motherboardBios')]
    #[ORM\JoinColumn(nullable: false)]
    private $motherboard;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @var File|null
     */
    #[Vich\UploadableField(mapping: 'bios', fileNameProperty: 'file_name')]
    private File|null $romFile;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'BIOS file name is longer than {{ limit }} characters, try to make it shorter.')]
    private string|null $file_name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'BIOS POST string is longer than {{ limit }} characters, try to make it shorter.')]
    private $postString;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class)]
    private $manufacturer;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'BIOS board version is longer than {{ limit }} characters, try to make it shorter.')]
    private $boardVersion;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'BIOS core version is longer than {{ limit }} characters, try to make it shorter.')]
    private $coreVersion;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'BIOS note is longer than {{ limit }} characters, try to make it shorter.')]
    private $note;

    public function __construct()
    {
        $this->updated_at = new \DateTime('now');
    }
    public function getId(): ?int
    {
        return $this->id;
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
    public function getFileName(): ?string
    {
        return $this->file_name;
    }
    public function setFileName(?string $file_name): self
    {
        $this->file_name = $file_name;

        return $this;
    }
    public function getPostString(): ?string
    {
        return $this->postString;
    }
    public function setPostString(?string $postString): self
    {
        $this->postString = $postString;

        return $this;
    }
    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }
    public function setManufacturer(?Manufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }
    public function getBoardVersion(): ?string
    {
        return $this->boardVersion;
    }
    public function setBoardVersion(?string $boardVersion): self
    {
        $this->boardVersion = $boardVersion;

        return $this;
    }
    public function getRomFile(): ?File
    {
        return $this->romFile;
    }
    public function setRomFile(?File $romFile): self
    {
        $this->romFile = $romFile;
        if ($this->romFile instanceof UploadedFile) {
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
    public function getCoreVersion(): ?string
    {
        return $this->coreVersion;
    }
    public function setCoreVersion(?string $coreVersion): self
    {
        $this->coreVersion = $coreVersion;

        return $this;
    }
    public function getNote(): ?string
    {
        return $this->note;
    }
    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
