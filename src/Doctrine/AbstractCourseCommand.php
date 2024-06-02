<?php

declare(strict_types=1);

namespace App\Doctrine;

use App\Course\Persister\CourseCommandInterface;
use App\Repository\CourseRepository;

abstract class AbstractCourseCommand implements CourseCommandInterface
{
    public function __construct(private readonly CourseRepository $courseRepository)
    {
    }
}
