<?php

declare(strict_types=1);

namespace App\History\Factory;

use App\Entity\Course;
use App\Entity\ViewHistory;

abstract class AbstractHistoryFactory
{
    abstract public function buildHistory(Course $course): ViewHistory;
}
