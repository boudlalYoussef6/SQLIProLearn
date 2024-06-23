<?php

declare(strict_types=1);

namespace App\Message\Handler;

use App\Message\CreatedIndexMessage;
use App\Repository\CourseRepository;
use App\Service\Indexation\CourseIndexerInterface;
use App\Transformer\CourseAdapterInterface;
use App\Transformer\CourseEntityToModelTransformer;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class IndexationMessageHandler
{
    private CourseIndexerInterface $courseIndexer;
    private CourseRepository $courseRepository;
    private CourseAdapterInterface $adapter;

    public function __construct(
        CourseIndexerInterface $courseIndexer,
        CourseRepository $courseRepository,
        #[Autowire(service: CourseEntityToModelTransformer::class)]
        CourseAdapterInterface $adapter,
    ) {
        $this->courseIndexer = $courseIndexer;
        $this->courseRepository = $courseRepository;
        $this->adapter = $adapter;
    }

    #[AsMessageHandler]
    public function createNewIndexForCourse(CreatedIndexMessage $message): void
    {
        $course = $this->courseRepository->find($message->getCourseReference());

        if (null !== $course) {
            $normalizedCourse = $this->adapter->convert($course);
            $this->courseIndexer->createNewIndex((string) $course->getId(), $normalizedCourse);
        }
    }
}
