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

    #[ORM\Column]
    private ?\DateTimeImmutable $dateVisit = null;

    #[ORM\Column(length: 255)]
    private ?string $visiter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVisit(): ?\DateTimeImmutable
    {
        return $this->dateVisit;
    }

    public function setDateVisit(\DateTimeImmutable $dateVisit): static
    {
        $this->dateVisit = $dateVisit;

        return $this;
    }

    public function getVisiter(): ?string
    {
        return $this->visiter;
    }

    public function setVisiter(string $visiter): static
    {
        $this->visiter = $visiter;

        return $this;
    }
}