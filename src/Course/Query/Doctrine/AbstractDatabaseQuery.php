<?php

declare(strict_types=1);

namespace App\Course\Query\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractDatabaseQuery
{
    public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
    }
}
