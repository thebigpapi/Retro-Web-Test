<?php

namespace App\Entity;

use App\Repository\LargeFileExpansionChipRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: LargeFileExpansionChipRepository::class)]
class LargeFileExpansionChip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: LargeFile::class, inversedBy: 'expansionchips')]
    #[ORM\JoinColumn(nullable: false)]
    private $largeFile;

    #[ORM\ManyToOne(targetEntity: Chip::class, inversedBy: 'drivers')]
    #[ORM\JoinColumn(nullable: false)]
    private $chip;

    #[ORM\Column(type: 'boolean')]
    private $isRecommended;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getLargeFile(): ?LargeFile
    {
        return $this->largeFile;
    }
    public function setLargeFile(?LargeFile $largeFile): self
    {
        $this->largeFile = $largeFile;

        return $this;
    }
    public function getChip(): ?Chip
    {
        return $this->chip;
    }
    public function setChip(?Chip $chip): self
    {
        $this->chip = $chip;

        return $this;
    }
    public function getIsRecommended(): ?bool
    {
        return $this->isRecommended;
    }
    public function setIsRecommended(bool $isRecommended): self
    {
        $this->isRecommended = $isRecommended;

        return $this;
    }
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if(null === $this->largeFile && $this->isRecommended) {
            $context->buildViolation('Driver is not selected!')
                ->atPath('largeFile')
                ->addViolation();
        }
    }
}
