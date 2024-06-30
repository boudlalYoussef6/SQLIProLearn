<?php

declare(strict_types=1);

namespace App\Course\Handler;

use App\Entity\Course;
use App\Indexation\Invoker\IndexationCommandInterface;
use App\Message\CreatedIndexMessage;
use App\Message\EditIndexMessage;
use App\Message\RevokeIndexMessage;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;

#[AsDecorator(decorates: CourseHandlerInterface::class)]
class DefaultCourseHandlerDecorator implements CourseHandlerInterface
{
    private LoggerInterface $logger;
    private Security $security;

    public function __construct(
        #[AutowireDecorated]
        private readonly CourseHandlerInterface $courseHandler,
        private readonly IndexationCommandInterface $indexer,
        LoggerInterface $logger,
        Security $security,
    ) {
        $this->logger = $logger;
        $this->security = $security;
    }

    public function add(Course $course): void
    {
        $user = $this->security->getUser();
        $userIdentifier = $user->getUserIdentifier();

        $this->courseHandler->add($course);

        $this->logger->info(sprintf(
            'Course added by user %s: Course ID %d, Title %s',
            $userIdentifier,
            $course->getId(),
            $course->getLabel()
        ));

        $this->indexer->execute(new CreatedIndexMessage($course->getId()));
    }

    public function edit(Course $course): void
    {
        $user = $this->security->getUser();
        $userIdentifier = $user->getUserIdentifier();

        $this->courseHandler->edit($course);
        $this->indexer->execute(new EditIndexMessage($course->getId()));
        $this->logger->info(\sprintf(
            'Course edited by user %s: Course ID %d, Title %s',
            $userIdentifier,
            $course->getId(),
            $course->getLabel()
        ));
    }

    public function delete(Course $course): void
    {
        $user = $this->security->getUser();
        $userIdentifier = $user->getUserIdentifier();

        try {
            $id = $course->getId();

            $this->courseHandler->delete($course);
            $this->logger->info(\sprintf(
                'Course deleted by user %s: Course ID %d, Title %s',
                $userIdentifier,
                $course->getId(),
                $course->getLabel()
            ));
            $this->indexer->execute(new RevokeIndexMessage($id));
        } catch (\Exception $error) {
            $this->logger->error(\sprintf('[ERROR][DELETE COURSE] %s',$error->getMessage()));
        }
    }
}
