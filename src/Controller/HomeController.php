<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ViewHistory;
use App\Service\ChartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ViewHistoryRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ViewHistoryRepository $viewHistoryRepository, ChartService $chartService): Response
    {
        $systemUsername = $this->getUser()->getUserIdentifier();

        /** @var ViewHistory[] $lastFourCourses */
        $lastFourCourses = $viewHistoryRepository->findLastVisitedCoursesForUser($systemUsername);

        $stats = [];

        foreach ($lastFourCourses as $course) {
            if (\array_key_exists($id = $course->getCourse()->getId(), $stats)) {
                continue;
            }

            $stats[$id] = $course;
        }

        $visitsData = $chartService->getVisitsData();
        $chartData = $chartService->getCoursesChartData();

        return $this->render('course/last_four_courses.html.twig', [
            'lastFourCourses' => $stats,
            'visitsData' => $visitsData,
            'chart_data' => $chartData,
        ]);
    }


}
