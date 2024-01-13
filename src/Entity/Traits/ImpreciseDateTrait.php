<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use DateTimeInterface;

trait ImpreciseDateTrait
{
    #[ORM\Column(type: 'date', nullable: true)]
    private ?DateTime $releaseDate = null;

    #[ORM\Column(type: 'string', length: 1, nullable: true)]
    private ?string $datePrecision = null;

    public function getReleaseDate(): ?DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?DateTimeInterface $releaseDate): self
    {
        if ($releaseDate) {
            $date = new DateTime();

            switch ($this->getDatePrecision()) {
                case "m":
                    $date->setDate($releaseDate->format("Y"), $releaseDate->format("m"), "1");
                    break;
                case "y":
                    $date->setDate($releaseDate->format("Y"), "1", "1");
                    break;
                default:
                    $date->setDate($releaseDate->format("Y"), $releaseDate->format("m"), $releaseDate->format("d"));
            }
            $this->releaseDate = $date;
        } else {
            $this->releaseDate = null;
        }

        return $this;
    }

    public function getReleaseDateString(): ?string
    {
        if ($this->releaseDate) {
            switch ($this->getDatePrecision()) {
                case "m":
                    return $this->releaseDate->format("Y-m");
                case "y":
                    return $this->releaseDate->format("Y");
                default:
                    return $this->releaseDate->format("Y-m-d");
            }
        } else {
            return null;
        }
    }

    public function getDatePrecision(): ?string
    {
        return $this->datePrecision;
    }

    public function setDatePrecision(?string $datePrecision): self
    {
        switch ($datePrecision) {
            case "m":
                $char = "m";
                break;
            case "y":
                $char = "y";
                break;
            default:
                $char = "d";
        }

        $this->datePrecision = $char;

        $this->setReleaseDate($this->getReleaseDate());

        return $this;
    }
}
