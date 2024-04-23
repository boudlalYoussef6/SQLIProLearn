<?php

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
    private ?User $userId = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $courseId = null;

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

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getCourseId(): ?Course
    {
        return $this->courseId;
    }

    public function setCourseId(?Course $courseId): static
    {
        $this->courseId = $courseId;

        return $this;
    }
}
