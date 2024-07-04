<?php

declare(strict_types=1);

namespace App\Controller;

use App\Course\Query\ItemQueryInterface;
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
    public function generateSummary(
        /* Course $course, */
        int $id,
        ItemQueryInterface $query,
        Security $security,
        FavoryRepository $favoriteRepository,
    ): Response {
        $course = $query->findItem((string) $id);

        if (null === $course) {
            throw $this->createNotFoundException();
        }

        $description = $course['description'];
        $user = $security->getUser()->getUserIdentifier();

        $isFavorite = $favoriteRepository->isFavorite($user, $course['id']);
        $summary = $this->courseSummaryService->generateSummary($description);

        return $this->render('course/details.html.twig', [
            'course' => $course,
            'summary' => $summary,
            'isFavorite' => $isFavorite,
        ]);
    }
}
