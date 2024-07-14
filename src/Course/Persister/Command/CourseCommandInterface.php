<?php

declare(strict_types=1);

namespace App\Course\Persister\Command;

use App\Entity\Course;

interface CourseCommandInterface
{
    public function run(Course $course): void;
}
