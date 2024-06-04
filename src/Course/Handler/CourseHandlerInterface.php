<?php

declare(strict_types=1);

namespace App\Course\Handler;

use App\Entity\Course;

interface CourseHandlerInterface
{
    public function add(Course $course): void;

    public function edit(Course $course): void;

    public function delete(Course $course): void;
}
