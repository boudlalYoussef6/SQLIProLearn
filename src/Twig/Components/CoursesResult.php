<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class CoursesResult
{
    public array $result;

    public array $favoriteCourses;

    public int $totalPages;

    public int $currentPage;
}
