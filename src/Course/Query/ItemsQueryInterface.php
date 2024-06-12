<?php

declare(strict_types=1);

namespace App\Course\Query;

interface ItemsQueryInterface
{
    public function findItems(): array;
}
