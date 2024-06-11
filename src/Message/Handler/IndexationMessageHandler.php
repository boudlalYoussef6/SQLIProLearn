<?php

declare(strict_types=1);

namespace App\Message\Handler;

use App\Message\CreatedIndexMessage;
use App\Repository\CourseRepository;
use App\Service\Indexation\CourseIndexerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class IndexationMessageHandler
{
    private CourseIndexerInterface $courseIndexer;
    private CourseRepository $courseRepository;

    public function __construct(CourseIndexerInterface $courseIndexer, CourseRepository $courseRepository)
    {
        $this->courseIndexer = $courseIndexer;
        $this->courseRepository = $courseRepository;
    }

    #[AsMessageHandler]
    public function createNewIndexForCourse(CreatedIndexMessage $message): void
    {
        $course = $this->courseRepository->find($message->getCourseReference());

        if ($course) {
            $this->courseIndexer->createNewIndex($course);
        }
    }
}
