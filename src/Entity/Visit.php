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
    #[ORM\JoinColumn(nullable: true)]
    private ?Course $course = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $timeVisit = null;

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
