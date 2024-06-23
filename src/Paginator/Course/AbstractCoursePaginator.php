<?php

declare(strict_types=1);

namespace App\Paginator\Course;

abstract class AbstractCoursePaginator implements CoursePaginatorInterface
{
    protected array $result;

    public function setResult(array $result): void
    {
        $this->result = $result;
    }
}
