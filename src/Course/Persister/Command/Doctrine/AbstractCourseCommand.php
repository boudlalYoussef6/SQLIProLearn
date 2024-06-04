<?php

declare(strict_types=1);

namespace App\Course\Persister\Command\Doctrine;

use App\Course\Persister\Command\CourseCommandInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractCourseCommand implements CourseCommandInterface
{
    public function __construct(protected readonly EntityManagerInterface $manager)
    {
    }
}
