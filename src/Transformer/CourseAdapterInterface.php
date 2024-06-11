<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Course;

interface CourseAdapterInterface
{
    public function convert(Course $course): object;
}
