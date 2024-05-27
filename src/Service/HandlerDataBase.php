<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;

class HandlerDataBase
{
    public function __construct(private readonly EntityManagerInterface $entityManager){
    }

    public function storeCourse(Course $course): void
    {
        $this->entityManager->persist($course);
        $this->entityManager->flush();
    }

}
