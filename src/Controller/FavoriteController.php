<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Course;
use App\Favorite\Command\Doctrine\AddToFavoriteCommand;
use App\Favorite\Command\Doctrine\RevokeFavoriteCommand;
use App\Favorite\Command\FavoriteCommandRunner;
use App\Favorite\Query\CollectionFavoritesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class FavoriteController extends AbstractController
{
    public function __construct(
        private readonly AddToFavoriteCommand $addToFavoriteCommand,
        private readonly RevokeFavoriteCommand $revokeFavoriteCommand,
    ) {
    }

    #[Route('/favorite/toggle/{id}', name: 'app_favorite_toggle', condition: "service('post_ajax_checker').isAjaxPostRequest(request)")]
    public function toggleFavorite(Course $course, FavoriteCommandRunner $commandRunner): Response
    {
        $commandRunner->run($this->addToFavoriteCommand, $course);

        return new JsonResponse(['status' => 'success', 'message' => 'Cours ajouté aux favoris']);
    }

    #[Route('/favorite/remove/{id}', name: 'app_favorite_remove', condition: "service('post_ajax_checker').isAjaxPostRequest(request)")]
    public function removeFavorite(Course $course, FavoriteCommandRunner $commandRunner): Response
    {
        $commandRunner->run($this->revokeFavoriteCommand, $course);

        return new JsonResponse(['status' => 'success', 'message' => 'Cours retiré de la liste des favoris']);
    }

    #[Route('/favorites', name: 'app_course_show')]
    public function showFavorites(CollectionFavoritesInterface $favorites): Response
    {
        $userFavorites = $favorites->all($this->getUser());

        return $this->render('favorite/index.html.twig', [
            'favoriteCollection' => $userFavorites,
        ]);
    }
}
