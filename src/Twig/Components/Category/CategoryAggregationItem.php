<?php

declare(strict_types=1);

namespace App\Twig\Components\Category;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class CategoryAggregationItem
{
    public bool $selected = false;

    public string $label;

    public array $category;

    public int $count;
}
