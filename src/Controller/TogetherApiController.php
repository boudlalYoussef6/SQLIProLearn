<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Course;
use App\Event\NewCourseEvent;
use App\Repository\FavoryRepository;
use App\Service\CourseSummaryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function generateSummary(Request $request, Course $course,
        Security $security,
        FavoryRepository $favoryRepository,
        EventDispatcherInterface $dispatcher): Response
    {
        $description = $course->getDescription();
        $user = $security->getUser()->getUserIdentifier();
        $userIdentifier = $this->getUser()->getUserIdentifier();

        $dispatcher->dispatch(new NewCourseEvent($course->getId(), $userIdentifier));

        $isFavorite = $favoryRepository->isFavorite($user, $course->getId());
        $summary = $this->courseSummaryService->generateSummary($description);

        return $this->render('course/details.html.twig', [
            'course' => $course,
            'summary' => $summary,
            'isFavorite' => $isFavorite,
        ]);
    }
}
