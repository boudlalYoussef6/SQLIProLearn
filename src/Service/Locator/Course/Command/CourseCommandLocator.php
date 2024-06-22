<?php

declare(strict_types=1);

namespace App\Service\Locator\Course\Command;

use App\Course\Persister\Command\CourseCommandInterface;
use App\Course\Persister\Command\Doctrine\AddCourseCommand;
use App\Course\Persister\Command\Doctrine\DeleteCourseCommand;
use App\Course\Persister\Command\Doctrine\UpdateCourseCommand;
use App\Service\Locator\AbstractCommandLocator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

final class CourseCommandLocator extends AbstractCommandLocator implements ServiceSubscriberInterface
{
    public static function getSubscribedServices(): array
    {
        return [
            'add_course_command' => AddCourseCommand::class,
            'edit_course_command' => UpdateCourseCommand::class,
            'remove_course_command' => DeleteCourseCommand::class,
        ];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function summon(string $service): CourseCommandInterface
    {
        if ($this->container->has($service)) {
            return $this->container->get($service);
        }

        throw new ServiceNotFoundException($service);
    }
}
