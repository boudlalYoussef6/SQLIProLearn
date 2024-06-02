<?php

declare(strict_types=1);

namespace App\MessageService;

class CreatedIndexMessage implements IndexationMessageInterface
{
    /**
     * @var int|null
     */
    private $courseReference;

    /**
     * Get the value of courseReference.
     */
    public function getCourseReference(): ?int
    {
        return $this->courseReference;
    }

    /**
     * Set the value of courseReference.
     */
    public function setCourseReference(?int $courseReference): self
    {
        $this->courseReference = $courseReference;

        return $this;
    }
}
