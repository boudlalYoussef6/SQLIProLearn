<?php

declare(strict_types=1);

namespace App\Message\Handler;

use App\Entity\Course;
use App\Message\CreatedIndexMessage;
use App\Message\EditIndexMessage;
use App\Message\RevokeIndexMessage;
use App\Repository\CourseRepository;
use App\Server\Mercure\Publisher\PublisherInterface;
use App\Service\Indexation\CourseIndexerInterface;
use App\Transformer\CourseAdapterInterface;
use App\Transformer\CourseEntityToModelTransformer;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
        private readonly PublisherInterface $publisher,
        private readonly UrlGeneratorInterface $generator,
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
            // notify the users that a new course has been recently indexed & added
            $this->doNotify($course);
        }
    }

    #[AsMessageHandler]
    public function editIndexForCourse(EditIndexMessage $message): void
    {
        $course = $this->courseRepository->find($message->getCourseReference());

        if (null !== $course) {
            $this->courseIndexer->removeNewIndex((string) $course->getId());

            $normalizedCourse = $this->adapter->convert($course);
            $this->courseIndexer->createNewIndex((string) $course->getId(), $normalizedCourse);
        }
    }

    #[AsMessageHandler]
    public function deleteIndexForCourse(RevokeIndexMessage $message): void
    {
        $courseIdentifier = $message->getCourseReference();

        $this->courseIndexer->removeNewIndex((string) $courseIdentifier);
    }

    private function doNotify(Course $course): void
    {
        $fullUrl = $this->generator->generate(
            'app_course_details',
            ['id' => $course->getId()],
        );
        $this->publisher->publish(
            'http://localhost/books/1',
            \json_encode(['course_url' => $fullUrl])
        );
    }
}
