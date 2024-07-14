<?php

declare(strict_types=1);

// src/Service/UdemyApiClientInterface.php

namespace App\Service;

interface UdemyApiClientInterface
{
    public function getCourses(): array;

    public function getCourseById(int $id): string;
}
