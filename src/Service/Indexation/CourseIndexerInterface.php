<?php

namespace App\Service\Indexation;

use App\Entity\Course;

interface CourseIndexerInterface
{
    public function createNewIndex(Course $course): void;
    public function removeNewIndex(Course $course): void;
}
