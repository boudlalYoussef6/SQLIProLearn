<?php

declare(strict_types=1);

namespace App\Message;

class CreatedIndexMessage implements IndexationMessageInterface
{
    private int $courseReference;

    public function __construct(int $courseReference)
    {
        $this->courseReference = $courseReference;
    }

    public function getCourseReference(): ?int
    {
        return $this->courseReference;
    }

    public function setCourseReference(?int $courseReference): self
    {
        $this->courseReference = $courseReference;

        return $this;
    }
}
