<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Course;
use App\Repository\FavoryRepository;
use App\Service\CourseSummaryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TogetherApiController extends AbstractController
{
    private CourseSummaryService $courseSummaryService;

    public function __construct(CourseSummaryService $courseSummaryService)
    {
        $this->courseSummaryService = $courseSummaryService;
    }

    #[Route('/summary/{id}', name: 'app_generate_summary', methods: ['POST'])]
    public function generateSummary(Course $course,
        Security $security,
        FavoryRepository $favoriteRepository,
    ): Response {
        $description = $course->getDescription();
        $user = $security->getUser()->getUserIdentifier();

        $isFavorite = $favoriteRepository->isFavorite($user, $course->getId());
        $summary = $this->courseSummaryService->generateSummary($description);

        return $this->render('course/details.html.twig', [
            'course' => $course,
            'summary' => $summary,
            'isFavorite' => $isFavorite,
        ]);
    }
}
