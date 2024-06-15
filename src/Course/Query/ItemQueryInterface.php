<?php

declare(strict_types=1);

namespace App\Course\Query;

interface ItemQueryInterface
{
    public function findItem(string $identifier): mixed;
}
