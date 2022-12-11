<?php

namespace App\Entity;

use App\Repository\IdRedirectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IdRedirectionRepository::class)]
#[ORM\InheritanceType('JOINED')]
abstract class IdRedirection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\Column(type: 'string')]
    private $source;
    
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max:255, maxMessage: 'Source is longer than {{ limit }} characters, try to make it shorter.')]
    private $sourceType;

    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?int
    {
        return $this->source;
    }

    public function setSource(int $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getSourceType(): ?string
    {
        return $this->sourceType;
    }

    public function setSourceType(string $sourceType): self
    {
        $this->sourceType = $sourceType;

        return $this;
    }
}
