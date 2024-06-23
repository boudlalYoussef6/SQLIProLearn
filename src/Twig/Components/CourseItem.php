<?php

declare(strict_types=1);

namespace App\Twig\Components;

use App\Entity\Course;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class CourseItem
{
    public Course|array $course;

    public array $favoriteCourses;
}
