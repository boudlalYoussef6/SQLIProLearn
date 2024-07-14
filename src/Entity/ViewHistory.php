<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ViewHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ViewHistoryRepository::class)]
class ViewHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateView = null;

    #[ORM\ManyToOne(inversedBy: 'viewHistories')]
    private ?Course $course = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDateView(): ?\DateTimeInterface
    {
        return $this->dateView;
    }

    public function setDateView(\DateTimeInterface $dateView): static
    {
        $this->dateView = $dateView;

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
