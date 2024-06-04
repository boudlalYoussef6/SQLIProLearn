<?php

declare(strict_types=1);

namespace App\Course\Handler;

use App\Entity\Course;
use App\Indexation\Invoker\IndexationCommandInterface;
use App\Message\CreatedIndexMessage;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;

#[AsDecorator(decorates: CourseHandlerInterface::class)]
class DefaultCourseHandlerDecorator implements CourseHandlerInterface
{
    public function __construct(
        #[AutowireDecorated]
        private readonly CourseHandlerInterface $courseHandler,
        private readonly IndexationCommandInterface $indexer,
    ) {
    }

    public function add(Course $course): void
    {
        // Persist the course
        $this->courseHandler->add($course);

        // Add the course to the indexation queue
        $this->indexer->execute(new CreatedIndexMessage($course->getId()));
    }

    public function edit(Course $course): void
    {
        $this->courseHandler->edit($course);
    }

    public function delete(Course $course): void
    {
        $this->courseHandler->delete($course);
    }
}
