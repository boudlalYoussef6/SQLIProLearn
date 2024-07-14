<?php

declare(strict_types=1);

namespace App\Message;

abstract class AbstractIndexMessage implements IndexationMessageInterface
{
    protected int $courseReference;

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
