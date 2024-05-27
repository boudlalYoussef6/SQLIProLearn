<?php

namespace App\Course\Persister;

use App\Repository\CourseRepository;
use App\Entity\Course;

class DefaultCoursePersister implements CoursePersisterInterface
{
    public function __construct(private readonly CourseRepository $courseRepository){
    }

    public function invoke(Course $course, CourseCommandInterface $command): void
    {
        $command->run($course);
        $this->courseRepository->add($course);
    }
}
