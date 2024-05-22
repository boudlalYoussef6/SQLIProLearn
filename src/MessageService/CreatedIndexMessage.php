<?php

namespace App\MessageService;

class CreatedIndexMessage implements IndexationMessageInterface
{
    /**
     * @var int|null
     */
    private $courseReference;

    /**
     * Get the value of courseReference
     *
     * @return int|null
     */
    public function getCourseReference(): ?int
    {
        return $this->courseReference;
    }

    /**
     * Set the value of courseReference
     *
     * @param int|null $courseReference
     * @return self
     */
    public function setCourseReference(?int $courseReference): self
    {
        $this->courseReference = $courseReference;
        return $this;
    }
}
