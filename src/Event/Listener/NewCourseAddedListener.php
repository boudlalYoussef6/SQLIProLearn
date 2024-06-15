<?php

declare(strict_types=1);

namespace App\Event\Listener;

use App\Entity\Course;
use App\Event\NewCourseEvent;
use App\History\Factory\DefaultHistoryFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewCourseAddedListener implements EventSubscriberInterface
{
    public function __construct(private readonly DefaultHistoryFactory $factory, private readonly EntityManagerInterface $manager)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NewCourseEvent::class => 'onNewCourseAdded',
        ];
    }

    public function onNewCourseAdded(NewCourseEvent $event): void
    {
        $course = $this->doRefreshCourse($event->getCourseId());

        if (null === $course) {
            return;
        }

        $course->incrementViews();
        $this->factory->saveNewViewHistory($course);
    }

    private function doRefreshCourse(int $courseIdentifier): ?Course
    {
        return $this->manager
            ->getRepository(Course::class)
            ->find($courseIdentifier);
    }
}
