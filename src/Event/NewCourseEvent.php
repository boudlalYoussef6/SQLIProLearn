<?php

declare(strict_types=1);

namespace App\Event;

class NewCourseEvent
{
    public function __construct(private int $courseId, private string $userIdentifier)
    {
    }

    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }
}
