<?php

declare(strict_types=1);

namespace App\Course\Handler;

use App\Course\Persister\Command\Doctrine\AddCourseCommand;
use App\Course\Persister\Command\Doctrine\DeleteCourseCommand;
use App\Course\Persister\Command\Doctrine\UpdateCourseCommand;
use App\Course\Persister\CoursePersisterInterface;
use App\Entity\Course;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias]
class DefaultCourseHandler implements CourseHandlerInterface
{
    public function __construct(
        private readonly CoursePersisterInterface $persister,
        private readonly AddCourseCommand $addCourseCommand,
        private readonly UpdateCourseCommand $editCourseCommand,
        private readonly DeleteCourseCommand $deleteCourseCommand,
    ) {
    }

    public function add(Course $course): void
    {
        $this->persister->invoke($course, $this->addCourseCommand);
    }

    public function edit(Course $course): void
    {
        $this->persister->invoke($course, $this->editCourseCommand);
    }

    public function delete(Course $course): void
    {
        $this->persister->invoke($course, $this->deleteCourseCommand);
    }
}
