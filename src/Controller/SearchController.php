<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\CourseSearchType;
use App\Repository\CourseRepository;
use App\Repository\FavoryRepository;
use App\Service\search\CourseSearchServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    #[Route('/course/search', name: 'app_course_search', priority: 2)]
    public function index(CourseRepository $courseRepository,
        Request $request,
        CourseSearchServiceInterface $courseSearchService,
        Security $security,
        FavoryRepository $favoryRepository): Response
    {
        $form = $this->createForm(CourseSearchType::class);

        $result = $courseSearchService->searchCourses(
            $courseRepository,
            $request,
            $form,
            $security,
            $favoryRepository
        );

        return $this->render('search/index.html.twig', [
            'pagination' => $result['pagination'],
            'favoriteCourses' => $result['favoriteCourses'],
            'form' => $form,
        ]);
    }
}
