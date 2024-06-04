<?php

declare(strict_types=1);

namespace App\Message;

interface IndexationMessageInterface
{
    public function getCourseReference(): ?int;

    public function setCourseReference(?int $courseReference): self;
}
