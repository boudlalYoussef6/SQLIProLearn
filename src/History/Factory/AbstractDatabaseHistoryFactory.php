<?php

declare(strict_types=1);

namespace App\History\Factory;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractDatabaseHistoryFactory extends AbstractHistoryFactory
{
    public function __construct(protected EntityManagerInterface $manager)
    {
    }

    public function saveNewViewHistory(Course $course): void
    {
        $viewHistory = $this->buildHistory($course);

        $this->manager->persist($viewHistory);
        $this->manager->flush();
    }
}
