<?php

declare(strict_types=1);

namespace App\Course\Persister\Command\Doctrine;

use App\Entity\Course;
use App\Repository\CourseRepository;

class UpdateCourseCommand extends AbstractCourseCommand
{
    public function run(Course $course): void
    {
        /** @var CourseRepository $repository */
        $repository = $this->manager->getRepository(Course::class);
        $repository->update($course);
    }
}
