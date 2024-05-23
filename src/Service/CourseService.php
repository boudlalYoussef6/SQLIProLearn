<?php

namespace App\Service;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;

class CourseService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createCourse(Course $course): void
    {
        $course->setType('sqli');
        $this->entityManager->persist($course);
        $this->entityManager->flush();
    }
}
