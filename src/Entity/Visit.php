<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\VisitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitRepository::class)]
class Visit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: "datetime")]
    private ?\DateTime $timeVisit = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeVisit(): ?\DateTimeInterface
    {
        return $this->timeVisit;
    }

    public function setTimeVisit(\DateTimeInterface $timeVisit): self
    {
        $this->timeVisit = $timeVisit;

        return $this;
    }

}
