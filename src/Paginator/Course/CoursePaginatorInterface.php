<?php

declare(strict_types=1);

namespace App\Paginator\Course;

interface CoursePaginatorInterface
{
    public function getResult(): array;

    public function getTotalPages(): int;
}
