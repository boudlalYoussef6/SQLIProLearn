<?php

declare(strict_types=1);

namespace App\Course\Query\Doctrine;

use App\Course\Query\ItemsQueryInterface;
use App\Entity\Course;

class GetAllCoursesQuery extends AbstractDatabaseQuery implements ItemsQueryInterface
{
    public function findItems(): array
    {
        return $this->entityManager->getRepository(Course::class)->findAll();
    }
}
