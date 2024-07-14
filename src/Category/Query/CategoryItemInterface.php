<?php

declare(strict_types=1);

namespace App\Category\Query;

interface CategoryItemInterface
{
    public function getItem(string $identifier): mixed;
}
