<?php

declare(strict_types=1);

namespace App\Service\Search;

use App\Repository\CourseRepository;
use App\Repository\FavoryRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface CourseSearchServiceInterface
{
    public function searchCourses(
        CourseRepository $courseRepository,
        Request $request,
        FormInterface $form,
        Security $security,
        FavoryRepository $favoryRepository
    ): array;
}
