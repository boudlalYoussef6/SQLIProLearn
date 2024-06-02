<?php

declare(strict_types=1);

namespace App\Course\Persister;

use App\Entity\Course;
use App\Repository\CourseRepository;

class DefaultCoursePersister implements CoursePersisterInterface
{
    public function __construct(private readonly CourseRepository $courseRepository)
    {
    }

    public function invoke(Course $course, CourseCommandInterface $command): void
    {
        $command->run($course);
        $this->courseRepository->add($course);
    }
}
