<?php

namespace App\Course\Persister;

use App\Entity\Course;

interface CourseCommandInterface
{
    public function run(Course $course): void;
}
