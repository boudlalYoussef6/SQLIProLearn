<?php

declare(strict_types=1);

namespace App\Course\Catalog;

use App\Contracts\PaginableInterface;

interface CatalogManagerInterface
{
    /**
     * This is equivalent to find all result.
     */
    public function populate(int $page): PaginableInterface;

    /**
     * This function filters the result with the given category.
     */
    public function filter(int $page, string $categoryIdentifier): PaginableInterface;
}
