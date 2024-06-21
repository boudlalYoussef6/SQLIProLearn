<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ViewHistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ViewHistoryRepository $viewHistoryRepository): Response
    {
        $systemUsername = $this->getUser()->getUserIdentifier();

        // Appeler la méthode du repository pour récupérer les 4 derniers cours consultés par cet utilisateur
        $lastFourCourses = $viewHistoryRepository->findLastVisitedCoursesForUser($systemUsername);

        return $this->render('course/last_four_courses.html.twig', [
            'lastFourCourses' => $lastFourCourses,
        ]);
    }
}
