<?php

namespace App\Doctrine;

use App\Course\Persister\CourseCommandInterface;
use App\Entity\Course;
use App\Repository\CourseRepository;

abstract class AbstractCourseCommand implements CourseCommandInterface
{
    public function __construct(private readonly CourseRepository $courseRepository){
    }
}
