<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Course;
use App\Favorite\Command\FavoriteCommandRunner;
use App\Favorite\Query\CollectionFavoritesInterface;
use App\Service\Locator\Favorite\Command\FavoriteCommandLocator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class FavoriteController extends AbstractController
{
    public function __construct(
        private readonly FavoriteCommandLocator $locator,
        private readonly FavoriteCommandRunner $commandRunner,
    ) {
    }

    #[Route('/favorite/toggle/{id}', name: 'app_favorite_toggle', condition: "service('post_ajax_checker').isAjaxPostRequest(request)")]
    public function toggleFavorite(Course $course): Response
    {
        $this->doInvokeCommand($course, 'add_course_to_favorite_command');

        return new JsonResponse(['status' => 'success', 'message' => 'Cours ajouté aux favoris']);
    }

    #[Route('/favorite/remove/{id}', name: 'app_favorite_remove', condition: "service('post_ajax_checker').isAjaxPostRequest(request)")]
    public function removeFavorite(Course $course): Response
    {
        $this->doInvokeCommand($course, 'revoke_course_from_favorite_command');

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

    private function doInvokeCommand(Course $course, string $commandServiceId)
    {
        $command = $this->locator->summon($commandServiceId);

        $this->commandRunner->run($command, $course);
    }
}
