<?php

declare(strict_types=1);

namespace App\Course\Query;

use App\Entity\Course;

interface ItemQueryInterface
{
    public function findItem(string $identifier): ?Course;
}
