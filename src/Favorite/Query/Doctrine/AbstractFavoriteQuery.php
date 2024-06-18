<?php

declare(strict_types=1);

namespace App\Favorite\Query\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractFavoriteQuery
{
    public function __construct(protected readonly EntityManagerInterface $manager)
    {
    }
}
