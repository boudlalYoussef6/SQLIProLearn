<?php

declare(strict_types=1);

namespace App\Category\Aggregation;

interface CategoryAggregationQueryInterface
{
    public function getAggregation(): array;
}
