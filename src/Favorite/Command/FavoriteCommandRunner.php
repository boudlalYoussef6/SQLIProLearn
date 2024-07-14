<?php

declare(strict_types=1);

namespace App\Favorite\Command;

use App\Entity\Course;

class FavoriteCommandRunner
{
    public function run(FavoriteCommandInterface $command, Course $course): void
    {
        $command->execute($course);
    }
}
