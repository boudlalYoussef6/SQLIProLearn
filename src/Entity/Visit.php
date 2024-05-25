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
    private ?int $nbrVisit = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $lastTimeVisit = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrVisit(): ?int
    {
        return $this->nbrVisit;
    }

    public function setNbrVisit(int $nbrVisit): static
    {
        $this->nbrVisit = $nbrVisit;

        return $this;
    }

    public function getLastTimeVisit(): ?\DateTimeImmutable
    {
        return $this->lastTimeVisit;
    }

    public function setLastTimeVisit(\DateTimeImmutable $lastTimeVisit): static
    {
        $this->lastTimeVisit = $lastTimeVisit;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }
}
