<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ChipsetBiosCodeRepository')]
class ChipsetBiosCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Chipset::class, inversedBy: 'biosCodes', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private $chipset;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'chipsetBiosCodes', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private $biosManufacturer;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'BIOS code is shorter than {{ limit }} characters.',
        maxMessage: 'BIOS code is longer than {{ limit }} characters.'
    )]
    #[Assert\NotBlank(
        message: 'BIOS code cannot be blank'
    )]
    private $code;

    public function getId(): ?int
    {
        return $this->id;
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
    public function getBiosManufacturer(): ?Manufacturer
    {
        return $this->biosManufacturer;
    }
    public function setBiosManufacturer(?Manufacturer $biosManufacturer): self
    {
        $this->biosManufacturer = $biosManufacturer;

        return $this;
    }
    public function getCode(): ?string
    {
        return $this->code;
    }
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
