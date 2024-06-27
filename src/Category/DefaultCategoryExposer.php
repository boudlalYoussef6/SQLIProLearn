<?php

declare(strict_types=1);

namespace App\Category;

use App\Category\Aggregation\CategoryAggregationQueryInterface;

class DefaultCategoryExposer implements CategoryExposerInterface
{
    public function __construct(
        private readonly CategoryAggregationQueryInterface $aggregationQuery,
    ) {
    }

    public function expose(): array
    {
        return $this->aggregationQuery->getAggregation();
    }
}
