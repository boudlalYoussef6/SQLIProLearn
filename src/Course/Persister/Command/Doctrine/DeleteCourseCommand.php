<?php

declare(strict_types=1);

namespace App\Course\Persister\Command\Doctrine;

use App\Entity\Course;
use App\Repository\CourseRepository;

class DeleteCourseCommand extends AbstractCourseCommand
{
    public function run(Course $course): void
    {
        /** @var CourseRepository $repository */
        $repository = $this->manager->getRepository(Course::class);
        $repository->remove($course);
    }
}
