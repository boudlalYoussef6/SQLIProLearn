<?php

declare(strict_types=1);

namespace App\Course\Query\Doctrine;

use App\Contracts\PaginableInterface;
use App\Course\Catalog\CatalogManagerInterface;
use App\Course\Query\ItemsQueryInterface;

class GetAllCoursesQuery implements ItemsQueryInterface
{
    public function __construct(private readonly CatalogManagerInterface $catalogManager)
    {
    }

    public function findItems(int $page): PaginableInterface
    {
        return $this->catalogManager->populate($page);
    }

    public function findItemsByCategory(int $page, string $categoryIdentifier): PaginableInterface
    {
        return $this->catalogManager->filter($page, $categoryIdentifier);
    }
}
