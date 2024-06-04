<?php

declare(strict_types=1);

namespace App\Course\Persister;

use App\Course\Persister\Command\CourseCommandInterface;
use App\Entity\Course;

class DefaultCoursePersister implements CoursePersisterInterface
{
    public function invoke(Course $course, CourseCommandInterface $command): void
    {
        $command->run($course);
    }
}
