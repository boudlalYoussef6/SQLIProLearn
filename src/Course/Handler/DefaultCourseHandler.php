<?php

declare(strict_types=1);

namespace App\Course\Handler;

use App\Course\Persister\CoursePersisterInterface;
use App\Entity\Course;
use App\Service\Locator\Course\Command\CourseCommandLocator;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias]
class DefaultCourseHandler implements CourseHandlerInterface
{
    public function __construct(
        private readonly CoursePersisterInterface $persister,
        private readonly CourseCommandLocator $locator,
    ) {
    }

    public function add(Course $course): void
    {
        $this->doInvokeCommand($course, 'add_course_command');
    }

    public function edit(Course $course): void
    {
        $this->doInvokeCommand($course, 'edit_course_command');
    }

    public function delete(Course $course): void
    {
        $this->doInvokeCommand($course, 'remove_course_command');
    }

    private function doInvokeCommand(Course $course, string $commandServiceId)
    {
        $command = $this->locator->summon($commandServiceId);

        $this->persister->invoke($course, $command);
    }
}
