<?php

declare(strict_types=1);

namespace App\Course\Persister;

use App\Course\Persister\Command\CourseCommandInterface;
use App\Entity\Course;

interface CoursePersisterInterface
{
    public function invoke(Course $course, CourseCommandInterface $command): void;
}
