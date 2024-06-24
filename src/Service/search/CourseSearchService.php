<?php

declare(strict_types=1);

namespace App\Service\search;

use App\Repository\CourseRepository;
use App\Repository\FavoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class CourseSearchService implements CourseSearchServiceInterface
{
    private PaginatorInterface $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    public function searchCourses(
        CourseRepository $courseRepository,
        Request $request,
        FormInterface $form,
        Security $security,
        FavoryRepository $favoryRepository
    ): array {
        $form->handleRequest($request);

        $queryBuilder = $courseRepository->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC');

        $pagination = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if (!empty($data['search'])) {
                $queryBuilder->andWhere('c.label LIKE :search OR c.description LIKE :search')
                    ->setParameter('search', '%'.$data['search'].'%');
            }

            $pagination = $this->paginator->paginate(
                $queryBuilder,
                $request->query->getInt('page', 1),
                5
            );
        }

        $userIdentifier = $security->getUser()->getUserIdentifier();
        $favoriteCourses = $favoryRepository->findFavoriteCourses($userIdentifier);

        return [
            'pagination' => $pagination,
            'favoriteCourses' => $favoriteCourses,
        ];
    }
}
