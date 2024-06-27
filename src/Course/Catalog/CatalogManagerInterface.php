<?php

declare(strict_types=1);

namespace App\Course\Catalog;

use App\Contracts\PaginableInterface;

interface CatalogManagerInterface
{
    /**
     * This is equivalent to find all result.
     *
     * @param int $page
     *
     * @return PaginableInterface
     */
    public function populate(int $page): PaginableInterface;

    /**
     * This function filters the result with the given category.
     *
     * @param int $page
     * @param string $categoryIdentifier
     *
     * @return PaginableInterface
     */
    public function filter(int $page, string $categoryIdentifier): PaginableInterface;
}
