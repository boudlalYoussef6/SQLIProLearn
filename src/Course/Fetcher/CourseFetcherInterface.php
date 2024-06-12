<?php

declare(strict_types=1);

namespace App\Course\Fetcher;

interface CourseFetcherInterface
{
    public function fetch(int $id): string;
}
