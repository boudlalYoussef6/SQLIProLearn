<?php

namespace App\MessageService;

interface IndexationMessageInterface
{
    public function getCourseReference(): ?int;
    public function setCourseReference(?int $courseReference): self;

}