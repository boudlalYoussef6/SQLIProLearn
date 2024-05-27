<?php

namespace App\Doctrine;

use App\Course\Persister\CourseCommandInterface;
use App\Course\Persister\CoursePersisterInterface;
use App\Entity\Course;
use App\Repository\CourseRepository;

class DeleteCourseCommand implements CourseCommandInterface
{
    public function __construct(private readonly CoursePersisterInterface $coursePersister){
    }

    public function execute(Course $course): void
    {
        $this->coursePersister->invoke($course, $this);
    }

    public function run(Course $course): void
    {
        $this->execute($course);
    }
}
