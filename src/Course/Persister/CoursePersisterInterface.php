<?php

namespace App\Course\Persister;

use App\Entity\Course;

interface CoursePersisterInterface
{
    public function invoke(Course $course, CourseCommandInterface $command): void;
}
