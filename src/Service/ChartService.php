<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class ChartService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getVisitsData()
    {
        $query = $this->entityManager->createQuery('
            SELECT SUBSTRING(v.dateVisit, 1, 10) as visitDate, COUNT(v.id) as visitCount
            FROM App\Entity\Visit v
            GROUP BY visitDate
            ORDER BY visitDate ASC
        ');

        return $query->getResult();
    }

    public function getCoursesChartData()
    {
        $courses = $this->entityManager->getRepository(\App\Entity\Course::class)->findAll();

        $chartData = [];
        foreach ($courses as $course) {
            $chartData[$course->getLabel()] = $course->getViews();
        }

        return $chartData;
    }
}
