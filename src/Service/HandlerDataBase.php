<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;

class HandlerDataBase
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function storeCourse(Course $course)
    {
        $this->entityManager->persist($course);
        $this->entityManager->flush();
    }
}
