<?php

declare(strict_types=1);

namespace App\Course\Query;

use App\Contracts\PaginableInterface;

interface ItemsQueryInterface
{
    public function findItems(int $page): PaginableInterface;

    public function findItemsByCategory(int $page, string $categoryIdentifier): PaginableInterface;
}
