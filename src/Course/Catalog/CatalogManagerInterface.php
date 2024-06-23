<?php

declare(strict_types=1);

namespace App\Course\Catalog;

use App\Contracts\PaginableInterface;

interface CatalogManagerInterface
{
    public function populate(int $page): PaginableInterface;
}
