<?php

declare(strict_types=1);

namespace App\Twig\Components\Course;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class MyCourses
{
    public mixed $course;
}