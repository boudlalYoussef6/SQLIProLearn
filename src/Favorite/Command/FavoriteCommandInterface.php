<?php

declare(strict_types=1);

namespace App\Favorite\Command;

use App\Entity\Course;

interface FavoriteCommandInterface
{
    public function execute(Course $course): void;
}
