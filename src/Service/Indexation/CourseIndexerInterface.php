<?php

declare(strict_types=1);

namespace App\Service\Indexation;

use App\Entity\Course;

interface CourseIndexerInterface
{
    public function createNewIndex(Course $course): void;

    public function removeNewIndex(Course $course): void;
}
